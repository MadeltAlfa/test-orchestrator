<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SkillTest;
use App\Services\ScoreConversionService;
use Illuminate\Http\Request;

class ScoreTestController extends Controller
{
    /**
     * Constructor injection for ScoreConversionService.
     */
    public function __construct(
        protected ScoreConversionService $scoreConversionService
    ) {}

    /**
     * Display a listing of tests that can be scored.
     */
    public function index()
    {
        $tests = SkillTest::orderBy('name', 'asc')->get();

        return view('user.score-tests.index', compact('tests'));
    }

    /**
     * Show a specific test scoring calculator.
     */
    public function show($id)
    {
        $test = SkillTest::with('norms')->findOrFail($id);

        return view('user.score-tests.show', compact('test'));
    }

    /**
     * Submit raw test values and see the converted score and category.
     */
    public function submit(Request $request)
    {
        $validated = $request->validate([
            'test_id' => 'required|uuid|exists:tests,id',
            'raw_value' => 'required|numeric|min:0',
        ]);

        $test = SkillTest::findOrFail($validated['test_id']);
        
        // Convert score using the service
        $conversion = $this->scoreConversionService->convert($test, (float) $validated['raw_value']);

        return view('user.score-tests.result', compact('test', 'validated', 'conversion'));
    }

    /**
     * JSON API Endpoint for real-time AJAX score conversion.
     */
    public function convertScore(Request $request)
    {
        $validated = $request->validate([
            'test_id' => 'required|uuid|exists:tests,id',
            'raw_value' => 'required|numeric|min:0',
        ]);

        $test = SkillTest::find($validated['test_id']);

        if (!$test) {
            return response()->json(['error' => 'Tes tidak ditemukan.'], 404);
        }

        $conversion = $this->scoreConversionService->convert($test, (float) $validated['raw_value']);

        return response()->json([
            'success' => true,
            'raw_value' => $validated['raw_value'],
            'score' => $conversion['score'],
            'category' => $conversion['category'],
            'unit' => $test->unit
        ]);
    }
}
