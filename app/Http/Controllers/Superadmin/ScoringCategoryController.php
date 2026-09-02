<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\ScoringCategory;
use App\Http\Requests\Superadmin\ScoringCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ScoringCategoryController extends Controller
{
    /**
     * Display a listing of scoring categories with pagination.
     */
    public function index()
    {
        $categories = ScoringCategory::orderBy('min_score', 'desc')
            ->paginate(10);

        return view('admin.scoring-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.scoring-categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(ScoringCategoryRequest $request)
    {
        try {
            DB::beginTransaction();

            $category = ScoringCategory::create($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.scoring-categories.index')
                ->with('success', "Kategori penilaian {$category->name} berhasil ditambahkan!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan kategori nilai: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan kategori penilaian.');
        }
    }

    /**
     * Display the specified category.
     */
    public function show(ScoringCategory $scoringCategory)
    {
        return view('admin.scoring-categories.show', compact('scoringCategory'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(ScoringCategory $scoringCategory)
    {
        return view('admin.scoring-categories.edit', compact('scoringCategory'));
    }

    /**
     * Update the specified category in storage.
     */
    public function update(ScoringCategoryRequest $request, ScoringCategory $scoringCategory)
    {
        try {
            DB::beginTransaction();

            $scoringCategory->update($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.scoring-categories.index')
                ->with('success', "Kategori penilaian {$scoringCategory->name} berhasil diperbarui!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui kategori nilai: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui kategori penilaian.');
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(ScoringCategory $scoringCategory)
    {
        try {
            DB::beginTransaction();

            $name = $scoringCategory->name;
            $scoringCategory->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.scoring-categories.index')
                ->with('success', "Kategori penilaian {$name} berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus kategori nilai: ' . $e->getMessage());

            return redirect()
                ->route('superadmin.scoring-categories.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kategori penilaian.');
        }
    }
}
