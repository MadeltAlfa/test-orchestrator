<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\SkillTest;
use App\Http\Requests\Superadmin\SkillTestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SkillTestController extends Controller
{
    /**
     * Display a listing of tests with pagination.
     */
    public function index()
    {
        $tests = SkillTest::withCount(['indicators', 'norms'])
            ->orderBy('name', 'asc')
            ->paginate(10);

        return view('admin.tests.index', compact('tests'));
    }

    /**
     * Show the form for creating a new test.
     */
    public function create()
    {
        return view('admin.tests.create');
    }

    /**
     * Store a newly created test in storage.
     */
    public function store(SkillTestRequest $request)
    {
        try {
            DB::beginTransaction();

            $test = SkillTest::create($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.tests.index')
                ->with('success', "Tes Keahlian {$test->name} berhasil ditambahkan!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan tes keahlian: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan tes keahlian. Coba lagi.');
        }
    }

    /**
     * Display the specified test.
     */
    public function show(SkillTest $skillTest)
    {
        $skillTest->load(['indicators', 'norms', 'guide']);

        return view('admin.tests.show', compact('skillTest'));
    }

    /**
     * Show the form for editing the specified test.
     */
    public function edit(SkillTest $skillTest)
    {
        return view('admin.tests.edit', compact('skillTest'));
    }

    /**
     * Update the specified test in storage.
     */
    public function update(SkillTestRequest $request, SkillTest $skillTest)
    {
        try {
            DB::beginTransaction();

            $skillTest->update($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.tests.index')
                ->with('success', "Tes Keahlian {$skillTest->name} berhasil diperbarui!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui tes keahlian: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui tes keahlian. Coba lagi.');
        }
    }

    /**
     * Remove the specified test from storage.
     */
    public function destroy(SkillTest $skillTest)
    {
        try {
            DB::beginTransaction();

            $testName = $skillTest->name;
            $skillTest->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.tests.index')
                ->with('success', "Tes Keahlian {$testName} berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus tes keahlian: ' . $e->getMessage());

            return redirect()
                ->route('superadmin.tests.index')
                ->with('error', 'Terjadi kesalahan saat menghapus tes keahlian. Pastikan tes tidak sedang digunakan.');
        }
    }
}
