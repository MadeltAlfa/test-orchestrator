<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Services\AssessmentService;
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
     * Display a listing of assessments with pagination and eager loaded relations.
     * withCount merges per-row COUNT queries into single query (no N+1).
     * orWhereHas dibungkus closure where agar precedence AND/OR aman.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Assessment::with(['user', 'player', 'finalPosition'])
            ->withCount(['testResults', 'scores']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('player', function ($pq) use ($search) {
                    $pq->where('name', 'like', "%{$search}%");
                })->orWhereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%");
                })->orWhereHas('finalPosition', function ($fq) use ($search) {
                    $fq->where('name', 'like', "%{$search}%")
                       ->orWhere('code', 'like', "%{$search}%");
                });
            });
        }

        $assessments = $query->orderBy('assessment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.assessments.index', compact('assessments', 'search'));
    }

    /**
     * Display the specified assessment details.
     */
    public function show(Assessment $assessment)
    {
        $assessment->load([
            'user',
            'player',
            'testResults.test',
            'scores.indicator',
            'results.position',
            'finalPosition'
        ]);

        return view('admin.assessments.show', compact('assessment'));
    }

    /**
     * Remove the specified assessment from storage.
     */
    public function destroy(Assessment $assessment)
    {
        try {
            DB::beginTransaction();

            $playerName = $assessment->player?->name ?? $assessment->user?->name ?? 'Pemain';
            $date = $assessment->assessment_date?->format('d-m-Y') ?? '-';

            $assessment->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.assessments.index')
                ->with('success', "Assessment untuk {$playerName} tanggal {$date} berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus assessment: ' . $e->getMessage());

            return redirect()
                ->route('superadmin.assessments.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data assessment.');
        }
    }

    /**
     * Render print-ready HTML page for downloading or printing PDF.
     */
    public function printPdf(Assessment $assessment)
    {
        $assessment->load([
            'user',
            'player',
            'testResults.test',
            'scores.indicator',
            'results.position',
            'finalPosition'
        ]);

        return view('user.pdf.assessment', compact('assessment'));
    }
}
