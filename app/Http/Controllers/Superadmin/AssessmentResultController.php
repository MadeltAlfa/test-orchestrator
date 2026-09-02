<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\AssessmentResult;
use App\Models\Position;
use Illuminate\Http\Request;

class AssessmentResultController extends Controller
{
    /**
     * Display a listing of assessment results (ranked position suitability).
     */
    public function index(Request $request)
    {
        $positionId = $request->query('position_id');
        $search = $request->query('search');

        $query = AssessmentResult::with([
            'assessment.user.playerProfile',
            'position'
        ]);

        if ($positionId) {
            $query->where('position_id', $positionId);
        }

        if ($search) {
            $query->whereHas('assessment.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        // Sort by rank and score
        $results = $query->orderBy('score', 'desc')
            ->orderBy('ranking', 'asc')
            ->paginate(10);

        $positions = Position::orderBy('name', 'asc')->get();

        return view('admin.assessment-results.index', compact('results', 'positions', 'positionId', 'search'));
    }

    /**
     * Display the specified assessment result detail.
     */
    public function show($id)
    {
        $result = AssessmentResult::with([
            'assessment.user.playerProfile',
            'assessment.scores.indicator',
            'position.indicators'
        ])->findOrFail($id);

        return view('admin.assessment-results.show', compact('result'));
    }
}
