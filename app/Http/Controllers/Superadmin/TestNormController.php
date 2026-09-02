<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\TestNorm;
use App\Models\SkillTest;
use App\Http\Requests\Superadmin\TestNormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestNormController extends Controller
{
    /**
     * Display a listing of test norms with pagination.
     */
    public function index(Request $request)
    {
        $tests = SkillTest::orderBy('name', 'asc')->get();
        $testId = $request->query('test_id');

        // Default to the first test if no test_id is specified
        if (!$testId && $tests->isNotEmpty()) {
            $testId = $tests->first()->id;
        }

        $test = $testId ? SkillTest::find($testId) : null;

        $query = TestNorm::with('test');

        if ($testId) {
            $query->where('test_id', $testId);
        }

        $norms = $query->orderBy('test_id')
            ->orderBy('score', 'desc')
            ->paginate(10);

        return view('admin.norms.index', compact('norms', 'tests', 'testId', 'test'));
    }

    /**
     * Show the form for creating a new test norm.
     */
    public function create(Request $request)
    {
        $testId = $request->query('test_id');
        $tests = SkillTest::orderBy('name', 'asc')->get();

        $operators = [
            'between' => 'Di antara (min & max)',
            'less_than' => 'Kurang dari (< max)',
            'greater_than' => 'Lebih dari (> min)',
            'less_equal' => 'Kurang dari sama dengan (≤ max)',
            'greater_equal' => 'Lebih dari sama dengan (≥ min)',
        ];

        return view('admin.norms.create', compact('tests', 'testId', 'operators'));
    }

    /**
     * Store a newly created test norm in storage.
     */
    public function store(TestNormRequest $request)
    {
        try {
            DB::beginTransaction();

            $norm = TestNorm::create($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.norms.index', ['test_id' => $norm->test_id])
                ->with('success', 'Norma penilaian berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan norma tes: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan norma penilaian.');
        }
    }

    /**
     * Display the specified test norm.
     */
    public function show(TestNorm $testNorm)
    {
        $testNorm->load('test');

        return view('admin.norms.show', compact('testNorm'));
    }

    /**
     * Show the form for editing the specified test norm.
     */
    public function edit(TestNorm $testNorm)
    {
        $testNorm->load('test');
        $tests = SkillTest::orderBy('name', 'asc')->get();

        $operators = [
            'between' => 'Di antara (min & max)',
            'less_than' => 'Kurang dari (< max)',
            'greater_than' => 'Lebih dari (> min)',
            'less_equal' => 'Kurang dari sama dengan (≤ max)',
            'greater_equal' => 'Lebih dari sama dengan (≥ min)',
        ];

        return view('admin.norms.edit', compact('testNorm', 'tests', 'operators'));
    }

    /**
     * Update the specified test norm in storage.
     */
    public function update(TestNormRequest $request, TestNorm $testNorm)
    {
        try {
            DB::beginTransaction();

            $testNorm->update($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.norms.index', ['test_id' => $testNorm->test_id])
                ->with('success', 'Norma penilaian berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui norma tes: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui norma penilaian.');
        }
    }

    /**
     * Remove the specified test norm from storage.
     */
    public function destroy(TestNorm $testNorm)
    {
        try {
            DB::beginTransaction();

            $testId = $testNorm->test_id;
            $testNorm->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.norms.index', ['test_id' => $testId])
                ->with('success', 'Norma penilaian berhasil dihapus!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus norma tes: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menghapus norma penilaian.');
        }
    }
}
