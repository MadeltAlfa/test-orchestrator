<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\PositionCheckRequest;
use App\Models\Assessment;
use App\Models\SkillTest;
use App\Models\Indicator;
use App\Models\AssessmentScore;
use App\Services\AssessmentService;
use App\Services\PositionCalculationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PositionCheckController extends Controller
{
    /**
     * Constructor injection for services.
     */
    public function __construct(
        protected AssessmentService $assessmentService,
        protected PositionCalculationService $positionCalculationService
    ) {}

    /**
     * Display the position check input form (Live / Test-based).
     */
    public function index()
    {
        // Eager load indicators and norms associated with each test
        $tests = SkillTest::with(['indicators', 'norms'])
            ->orderBy('name', 'asc')
            ->get();

        $players = auth()->user()->players()->orderBy('name')->get();

        // Ambil semua posisi beserta indikator dan tesnya
        $positions = \App\Models\Position::with('indicators.tests')->orderBy('name', 'asc')->get();
        $positionTestMap = [];

        foreach ($positions as $position) {
            $testIds = [];
            foreach ($position->indicators as $indicator) {
                foreach ($indicator->tests as $test) {
                    $testIds[] = $test->id;
                }
            }
            $positionTestMap[$position->id] = array_unique($testIds);
        }

        return view('user.position-check.index', compact('tests', 'players', 'positions', 'positionTestMap'));
    }

    /**
     * Store a completed test-based assessment (Live).
     */
    public function store(PositionCheckRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();
            
            // Handle player creation if necessary
            $playerId = $request->player_id;
            if (!$playerId && $request->new_player_name && $request->new_player_dob) {
                $player = $user->players()->create([
                    'name' => $request->new_player_name,
                    'dob' => $request->new_player_dob,
                ]);
                $playerId = $player->id;
            }

            $payload = $request->validated();
            $payload['player_id'] = $playerId;
            
            // AssessmentService handles raw test saving, score conversion, weighted calculations, and ranking
            $assessment = $this->assessmentService->createAssessment($user, $payload);

            DB::commit();

            return redirect()
                ->route('user.position-check.result', $assessment->id)
                ->with('success', 'Penentuan posisi (Live) berhasil diproses dan disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memproses penentuan posisi (store): ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses data. Silakan periksa kembali input Anda.');
        }
    }

    /**
     * Display the manual indicator score input form.
     */
    public function inputScore()
    {
        $players = auth()->user()->players()->orderBy('name')->get();

        // Get all indicators dynamically from the database
        $indicators = Indicator::orderBy('name', 'asc')->get();

        // Ambil semua posisi dan petakan indikatornya
        $positions = \App\Models\Position::with('indicators')->orderBy('name', 'asc')->get();
        $positionIndicatorMap = [];
        
        foreach ($positions as $position) {
            $positionIndicatorMap[$position->id] = $position->indicators->pluck('id')->toArray();
        }

        return view('user.position-check.input-score', compact('indicators', 'players', 'positions', 'positionIndicatorMap'));
    }

    /**
     * Store a manually entered indicator score-based assessment.
     */
    public function storeInputScore(Request $request)
    {
        $indicators = Indicator::orderBy('name', 'asc')->get();

        // Build validation rules for each indicator dynamically
        $rules = [
            'assessment_date' => ['nullable', 'date'],
            'player_id' => ['nullable', 'exists:players,id'],
            'new_player_name' => ['nullable', 'string', 'max:255', 'required_without:player_id'],
            'new_player_dob' => ['nullable', 'date', 'required_without:player_id'],
        ];
        
        $inputScores = $request->input('scores', []);
        foreach ($inputScores as $id => $val) {
            $rules['scores.' . $id] = ['required', 'integer', 'between:0,10'];
        }

        $validated = $request->validate($rules, [], [
            'assessment_date' => 'Tanggal Assessment'
        ]);

        try {
            DB::beginTransaction();

            $user = auth()->user();

            $playerId = $request->player_id;
            if (!$playerId && $request->new_player_name && $request->new_player_dob) {
                $player = $user->players()->create([
                    'name' => $request->new_player_name,
                    'dob' => $request->new_player_dob,
                ]);
                $playerId = $player->id;
            }

            // 1. Create Assessment Header
            $assessment = Assessment::create([
                'user_id' => $user->id,
                'player_id' => $playerId,
                'assessment_date' => $validated['assessment_date'] ?? now()->toDateString(),
            ]);

            // 2. Save Scores manually entered for each indicator
            $inputScores = $request->input('scores', []);
            foreach ($indicators as $indicator) {
                $scoreValue = (int) ($inputScores[$indicator->id] ?? 0);

                AssessmentScore::create([
                    'assessment_id' => $assessment->id,
                    'indicator_id' => $indicator->id,
                    'indicator_name' => $indicator->name,
                    'score' => $scoreValue,
                ]);
            }

            // 3. Process Position Calculations and save results using AssessmentService
            $this->assessmentService->saveResults($assessment);

            DB::commit();

            return redirect()
                ->route('user.position-check.result', $assessment->id)
                ->with('success', 'Penentuan posisi (Manual) berhasil dihitung dan disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan penentuan posisi skor manual: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses data. Silakan coba lagi.');
        }
    }

    /**
     * Calculate position recommendations without saving (Simulation Mode).
     */
    public function calculate(PositionCheckRequest $request)
    {
        try {
            $validated = $request->validated();
            $user = auth()->user();

            // Perform calculation in memory or temporary database transaction
            DB::beginTransaction();

            $assessment = $this->assessmentService->createAssessment($user, $validated);
            $results = $assessment->results()->with('position')->orderBy('ranking', 'asc')->get();

            // Rollback transaction to prevent saving the test to history
            DB::rollBack();

            return view('user.position-check.simulation', compact('assessment', 'results'));
        } catch (\Throwable $e) {
            Log::error('Gagal menjalankan simulasi penentuan posisi: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menghitung simulasi.');
        }
    }

    /**
     * Display the final result of a saved assessment.
     */
    public function result($id)
    {
        $assessment = Assessment::where('user_id', auth()->id())
            ->with([
                'user.playerProfile',
                'player',
                'testResults.test',
                'scores.indicator',
                'results.position',
                'finalPosition'
            ])
            ->findOrFail($id);

        // Get ranked positions sorting
        $results = $assessment->results()
            ->with('position')
            ->orderBy('ranking', 'asc')
            ->get();

        return view('user.position-check.result', compact('assessment', 'results'));
    }
}
