<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Models\Assessment;
use App\Models\AssessmentTestResult;
use App\Models\AssessmentScore;
use App\Models\AssessmentResult;
use App\Models\SkillTest;
use App\Models\Indicator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class AssessmentService
{
    /**
     * Constructor injection untuk dependensi service terkait.
     */
    public function __construct(
        protected ScoreConversionService $scoreConversionService,
        protected PositionCalculationService $positionCalculationService
    ) {}

    /**
     * Membuat assessment lengkap untuk seorang user/pemain baru.
     *
     * @param User $user
     * @param array{assessment_date?: string, results: array<string, float>} $payload
     * @return Assessment
     */
    public function createAssessment(User $user, array $payload): Assessment
    {
        return DB::transaction(function () use ($user, $payload) {
            // 1. Inisialisasi data Assessment utama
            $assessment = Assessment::create([
                'user_id' => $user->id,
                'player_id' => $payload['player_id'] ?? null,
                'assessment_date' => $payload['assessment_date'] ?? now()->toDateString(),
            ]);

            // 2. Simpan hasil tes mentah (Raw Test Results) dan konversi nilainya
            $this->saveTestResults($assessment, $payload['results'] ?? []);

            // 3. Hitung dan simpan skor untuk setiap indikator (Assessment Scores)
            $this->saveScores($assessment);

            // 4. Hitung kelayakan posisi, berikan ranking, dan simpan hasilnya (Assessment Results)
            $this->saveResults($assessment);

            // Eager load seluruh relasi penting agar siap dikonsumsi controller/API
            return $assessment->load([
                'testResults.test',
                'scores.indicator',
                'results.position',
                'finalPosition'
            ]);
        });
    }

    /**
     * Mengonversi dan menyimpan hasil tes mentah (raw test results).
     *
     * @param Assessment $assessment
     * @param array<string, float> $testResults Array of [test_id => raw_value]
     * @return Collection<int, AssessmentTestResult>
     */
    public function saveTestResults(Assessment $assessment, array $testResults): Collection
    {
        $savedResults = collect();

        foreach ($testResults as $testId => $rawValue) {
            $test = SkillTest::find($testId);

            if ($test === null) {
                continue;
            }

            // Konversi nilai hasil tes mentah menjadi skor dan kategori menggunakan conversion service
            $conversion = $this->scoreConversionService->convert($test, (float) $rawValue);

            $savedResults->push(
                AssessmentTestResult::create([
                    'assessment_id' => $assessment->id,
                    'test_id' => $testId,
                    'raw_value' => $rawValue,
                    'score' => $conversion['score'],
                    'category' => $conversion['category'],
                ])
            );
        }

        return $savedResults;
    }

    /**
     * Menghitung dan menyimpan skor untuk semua indikator berdasarkan rata-rata skor tes terkait.
     *
     * @param Assessment $assessment
     * @return Collection<int, AssessmentScore>
     */
    public function saveScores(Assessment $assessment): Collection
    {
        $savedScores = collect();
        
        // Ambil semua indikator berserta relasi tesnya untuk efisiensi query
        $indicators = Indicator::with(['tests'])->get();
        
        // Ambil semua hasil tes yang baru saja disimpan untuk assessment ini
        $testResults = $assessment->testResults;

        foreach ($indicators as $indicator) {
            $testIds = $indicator->tests->pluck('id');
            
            // Filter hasil tes yang relevan dengan indikator ini
            $matchingResults = $testResults->whereIn('test_id', $testIds);

            if ($matchingResults->isNotEmpty()) {
                // Rata-rata skor dari tes-tes pendukung indikator
                $averageScore = $matchingResults->avg('score');
                $finalScore = (int) round($averageScore);
            } else {
                $finalScore = 0;
            }

            $savedScores->push(
                AssessmentScore::create([
                    'assessment_id' => $assessment->id,
                    'indicator_id' => $indicator->id,
                    'indicator_name' => $indicator->name,
                    'score' => $finalScore,
                ])
            );
        }

        return $savedScores;
    }

    /**
     * Menghitung kecocokan posisi, meranking, dan memperbarui ringkasan penilaian assessment.
     *
     * @param Assessment $assessment
     * @return array<int, AssessmentResult>
     */
    public function saveResults(Assessment $assessment): array
    {
        // 1. Hitung skor kelayakan semua posisi berdasarkan skor indikator yang tersimpan
        $rankedPositions = $this->positionCalculationService->calculate($assessment);

        $savedResults = [];

        foreach ($rankedPositions as $result) {
            $savedResults[] = AssessmentResult::create([
                'assessment_id' => $assessment->id,
                'position_id' => $result['position_id'],
                'score' => $result['score'],
                'ranking' => $result['ranking'],
            ]);
        }

        // 2. Ambil ID posisi dengan ranking terbaik (Rank 1)
        $bestPosition = collect($rankedPositions)->firstWhere('ranking', 1);
        $bestPositionId = $bestPosition !== null ? $bestPosition['position_id'] : null;

        // 3. Update summary data pada assessment (posisi rekomendasi & total skor indikator)
        $assessment->update([
            'final_position_id' => $bestPositionId,
            'total_score' => $assessment->calculateTotalScore(),
        ]);

        return $savedResults;
    }
}
