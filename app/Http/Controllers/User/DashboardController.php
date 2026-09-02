<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Player;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the coach's dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // 1. Total statistics for this coach
        $totalPlayers = Player::where('coach_id', $user->id)->count();
        $totalAssessments = Assessment::where('user_id', $user->id)->count();
        
        $thisMonthAssessments = Assessment::where('user_id', $user->id)
            ->whereMonth('assessment_date', now()->month)
            ->whereYear('assessment_date', now()->year)
            ->count();

        $avgScore = Assessment::where('user_id', $user->id)->avg('total_score');

        // 2. Recent Players with assessment count & latest assessment
        $recentPlayers = Player::where('coach_id', $user->id)
            ->with(['assessments' => function ($q) {
                $q->with('finalPosition')->orderBy('assessment_date', 'desc')->orderBy('created_at', 'desc');
            }])
            ->withCount('assessments')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // 3. Position Distribution for players managed by this coach
        $positionDistribution = DB::table('assessments')
            ->join('positions', 'assessments.final_position_id', '=', 'positions.id')
            ->where('assessments.user_id', $user->id)
            ->select('positions.name', 'positions.code', DB::raw('count(*) as count'))
            ->groupBy('positions.id', 'positions.name', 'positions.code')
            ->orderBy('count', 'desc')
            ->get();

        // 4. Recent assessment activities
        $recentAssessments = Assessment::where('user_id', $user->id)
            ->with(['player', 'finalPosition'])
            ->orderBy('assessment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('user.dashboard', compact(
            'totalPlayers',
            'totalAssessments',
            'thisMonthAssessments',
            'avgScore',
            'recentPlayers',
            'positionDistribution',
            'recentAssessments'
        ));
    }
}
