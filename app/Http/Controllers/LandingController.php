<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\Indicator;
use App\Models\SkillTest;
use App\Models\Assessment;
use App\Models\TestGuide;

class LandingController extends Controller
{
    /**
     * Show the public landing / welcome page with real stats from DB.
     */
    public function index()
    {
        $positions   = Position::with(['indicators'])->get();
        $totalPositions   = $positions->count();
        $totalIndicators  = Indicator::count();
        $totalTests       = SkillTest::count();
        $totalAssessments = Assessment::count();
        $skillTests       = SkillTest::all();

        return view('welcome', compact(
            'positions',
            'totalPositions',
            'totalIndicators',
            'totalTests',
            'totalAssessments',
            'skillTests'
        ));
    }

    /**
     * Show the public position guide page (static HTML converted to Blade).
     */
    public function panduanPosisi()
    {
        $positions = Position::with(['indicators.tests.guide'])->get();

        return view('landing-page.panduan-posisi', compact('positions'));
    }

    /**
     * Show the public Panduan Tes page (list of test guides).
     */
    public function panduanTes()
    {
        $guides = TestGuide::with([
            'test',
            'sections' => fn($q) => $q->orderBy('sort_order'),
        ])->orderBy('title')->get();

        return view('landing-page.panduan-tes', compact('guides'));
    }

    /**
     * Show a single public test guide page.
     */
    public function panduanTesShow($id)
    {
        $guide = TestGuide::with([
            'test.norms' => fn($q) => $q->orderBy('score', 'desc'),
            'sections'   => fn($q) => $q->orderBy('sort_order'),
        ])->where('id', $id)
          ->orWhere('test_id', $id)
          ->firstOrFail();

        return view('landing-page.panduan-tes-show', compact('guide'));
    }
}
