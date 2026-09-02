<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Indicator;
use App\Models\SkillTest;
use App\Models\IndicatorTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class IndicatorTestController extends Controller
{
    /**
     * Display a listing of tests for a specific indicator.
     */
    public function index($indicatorId)
    {
        $indicator = Indicator::findOrFail($indicatorId);
        
        // Eager load associated tests
        $indicator->load(['tests' => function ($query) {
            $query->orderBy('name', 'asc');
        }]);

        // Get tests that are not yet assigned to this indicator
        $assignedTestIds = $indicator->tests->pluck('id')->toArray();
        $availableTests = SkillTest::whereNotIn('id', $assignedTestIds)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.indicator-tests.index', compact('indicator', 'availableTests'));
    }

    /**
     * Store a newly created indicator-test relation in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'indicator_id' => 'required|uuid|exists:indicators,id',
            'test_id' => 'required|uuid|exists:tests,id',
        ]);

        try {
            DB::beginTransaction();

            $indicator = Indicator::findOrFail($validated['indicator_id']);
            
            // Attach test to indicator with custom UUID primary key
            $indicator->tests()->attach($validated['test_id'], [
                'id' => (string) Str::uuid(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('superadmin.indicator-tests.index', $validated['indicator_id'])
                ->with('success', 'Tes berhasil dikaitkan dengan indikator!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal mengaitkan tes ke indikator: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Pastikan tes belum terhubung ke indikator ini.');
        }
    }

    /**
     * Remove the relation from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $pivot = IndicatorTest::findOrFail($id);
            $indicatorId = $pivot->indicator_id;
            
            $pivot->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.indicator-tests.index', $indicatorId)
                ->with('success', 'Tes berhasil dilepas dari indikator!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal melepas tes dari indikator: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat melepas tes.');
        }
    }
}
