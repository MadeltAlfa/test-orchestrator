<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Assessment;
use App\Models\Position;
use Illuminate\Support\Collection;

class PositionCalculationService
{
    /**
     * Hitung skor kelayakan untuk semua posisi berdasarkan hasil assessment.
     *
     * @param Assessment $assessment
     * @return array<int, array{position_id: string, position_name: string, score: float, ranking: int}>
     */
    public function calculate(Assessment $assessment): array
    {
        // Eager load indicators beserta pivot weight
        $positions = Position::with(['indicators'])->get();
        
        // Ambil semua skor indikator untuk assessment ini
        $scores = $assessment->scores;

        $results = [];

        foreach ($positions as $position) {
            $score = $this->calculatePositionScore($position, $scores);
            
            $results[] = [
                'position_id' => $position->id,
                'position_name' => $position->name,
                'score' => round($score, 2),
            ];
        }

        return $this->rankPositions($results);
    }

    /**
     * Hitung skor kelayakan untuk satu posisi tertentu menggunakan bobot indikator.
     *
     * Rumus: (Sum(Skor Indikator * Bobot Indikator) / Sum(Bobot Indikator)) * 10
     * Dikalikan 10 untuk menstandarisasi ke skala 100 (karena skor mentah berskala 0-10).
     *
     * @param Position $position
     * @param Collection $scores Collection of AssessmentScore
     * @return float
     */
    public function calculatePositionScore(Position $position, Collection $scores): float
    {
        $totalWeightedScore = 0.0;
        $totalWeight = 0.0;

        foreach ($position->indicators as $indicator) {
            $weight = (float) ($indicator->pivot?->weight ?? 1.0);
            
            // Cari skor indikator yang sesuai
            $assessmentScore = $scores->firstWhere('indicator_id', $indicator->id);
            $scoreValue = $assessmentScore !== null ? (float) $assessmentScore->score : 0.0;

            $totalWeightedScore += $scoreValue * $weight;
            $totalWeight += $weight;
        }

        if ($totalWeight === 0.0) {
            return 0.0;
        }

        // Skala 0-10 dikonversi ke skala 100 dengan dikali 10
        return ($totalWeightedScore / $totalWeight) * 10.0;
    }

    /**
     * Mengurutkan hasil perhitungan skor posisi dan memberikan ranking otomatis.
     *
     * @param array<int, array{position_id: string, position_name: string, score: float}> $results
     * @return array<int, array{position_id: string, position_name: string, score: float, ranking: int}>
     */
    public function rankPositions(array $results): array
    {
        // Urutkan berdasarkan skor tertinggi ke terendah
        usort($results, function (array $a, array $b) {
            return $b['score'] <=> $a['score'];
        });

        // Berikan ranking berurutan
        $rank = 1;
        foreach ($results as $index => $result) {
            $results[$index]['ranking'] = $rank++;
        }

        return $results;
    }
}
