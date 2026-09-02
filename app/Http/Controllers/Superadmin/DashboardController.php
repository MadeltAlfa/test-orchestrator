<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Player;
use App\Models\Assessment;
use App\Models\Position;
use App\Models\Indicator;
use App\Models\SkillTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the superadmin dashboard statistics.
     */
    public function index()
    {
        // 1. Get total counts
        $totalCoaches = User::where('role', 'user')->count();
        $totalPlayers = Player::count();
        $totalAssessments = Assessment::count();
        $thisMonthAssessments = Assessment::whereMonth('assessment_date', now()->month)
            ->whereYear('assessment_date', now()->year)
            ->count();
        $totalPositions = Position::count();
        $totalIndicators = Indicator::count();
        $totalTests = SkillTest::count();

        // 2. Get latest assessments (eager load user, player, and finalPosition)
        $latestAssessments = Assessment::with(['user', 'player', 'finalPosition'])
            ->orderBy('assessment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // 3. Prepare chart-ready statistics
        // Chart A: Assessment counts by date (last 30 days)
        $assessmentsByDate = Assessment::select(
                DB::raw('DATE(assessment_date) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('assessment_date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get()
            ->mapWithKeys(function ($item) {
                $dateStr = is_string($item->date) 
                    ? $item->date 
                    : (\is_object($item->date) ? $item->date->toDateString() : strval($item->date));
                return [$dateStr => $item->count];
            });

        // Chart B: recommended positions distribution
        $positionsDistribution = Assessment::select('final_position_id', DB::raw('COUNT(*) as count'))
            ->whereNotNull('final_position_id')
            ->groupBy('final_position_id')
            ->with('finalPosition')
            ->get()
            ->map(fn ($item) => [
                'position_name' => $item->finalPosition?->name ?? 'Unknown',
                'position_code' => $item->finalPosition?->code ?? 'UNK',
                'count' => $item->count
            ]);

        // Chart C: Average score by indicator
        $averageScoresByIndicator = DB::table('assessment_scores')
            ->select('indicator_name', DB::raw('ROUND(AVG(score), 2) as average_score'))
            ->groupBy('indicator_name')
            ->get();

        $statistics = [
            'assessments_by_date' => $assessmentsByDate,
            'positions_distribution' => $positionsDistribution,
            'average_scores_by_indicator' => $averageScoresByIndicator,
        ];

        return view('admin.dashboard', compact(
            'totalCoaches',
            'totalPlayers',
            'totalAssessments',
            'thisMonthAssessments',
            'totalPositions',
            'totalIndicators',
            'totalTests',
            'latestAssessments',
            'statistics'
        ));
    }
}
