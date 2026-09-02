<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentResult;
use Illuminate\Http\Request;

class AssessmentResultController extends Controller
{
    /**
     * Display a specific suitability position result.
     */
    public function show($id)
    {
        $result = AssessmentResult::with([
            'assessment.user.playerProfile',
            'position.indicators'
        ])->findOrFail($id);

        // Ensure the result belongs to the logged-in user
        if ($result->assessment->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak.');
        }

        return view('user.assessment-results.show', compact('result'));
    }

    /**
     * Display the complete position suitability rankings for an assessment.
     */
    public function ranking($assessmentId)
    {
        $assessment = Assessment::where('user_id', auth()->id())
            ->with(['finalPosition', 'user.playerProfile'])
            ->findOrFail($assessmentId);

        $rankings = AssessmentResult::where('assessment_id', $assessment->id)
            ->with(['position.indicators'])
            ->orderBy('ranking', 'asc')
            ->get();

        $bestPosition = $assessment->finalPosition;
        $totalScore = $assessment->total_score;

        return view('user.assessment-results.ranking', compact(
            'assessment',
            'rankings',
            'bestPosition',
            'totalScore'
        ));
    }
}
