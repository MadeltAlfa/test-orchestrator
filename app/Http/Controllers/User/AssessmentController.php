<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Services\AssessmentService;
use App\Http\Requests\User\PositionCheckRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AssessmentController extends Controller
{
    /**
     * Constructor injection for AssessmentService.
     */
    public function __construct(
        protected AssessmentService $assessmentService
    ) {}

    /**
     * Display a paginated list of user assessments.
     */
    public function index()
    {
        $user = auth()->user();

        $assessments = Assessment::where('user_id', $user->id)
            ->with(['finalPosition'])
            ->orderBy('assessment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.history.index', ['history' => $assessments]);
    }

    /**
     * Display a specific assessment's detailed indicators, test results, and ranking.
     */
    public function show($id)
    {
        $assessment = Assessment::where('user_id', auth()->id())
            ->with([
                'user.playerProfile',
                'testResults.test',
                'scores.indicator',
                'results.position',
                'finalPosition'
            ])
            ->findOrFail($id);

        $rankings = $assessment->results()
            ->with('position')
            ->orderBy('ranking', 'asc')
            ->get();

        return view('user.history.show', compact('assessment', 'rankings'));
    }

    /**
     * Store a new assessment via POST request.
     */
    public function store(PositionCheckRequest $request)
    {
        try {
            DB::beginTransaction();

            $user = auth()->user();
            $assessment = $this->assessmentService->createAssessment($user, $request->validated());

            DB::commit();

            return redirect()
                ->route('user.assessments.show', $assessment->id)
                ->with('success', 'Hasil penilaian posisi baru berhasil disimpan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal membuat assessment: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memproses data assessment.');
        }
    }
}
