<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\TestGuideSection;
use App\Models\TestGuide;
use App\Http\Requests\Superadmin\TestGuideSectionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestGuideSectionController extends Controller
{
    /**
     * Display a listing of sections with pagination.
     */
    public function index(Request $request)
    {
        $guideId = $request->query('test_guide_id') ?? $request->query('guide_id');

        if ($guideId) {
            return redirect()->route('superadmin.guides.show', $guideId);
        }

        return redirect()->route('superadmin.guides.index');
    }

    /**
     * Show the form for creating a new section.
     */
    public function create(Request $request)
    {
        $guideId = $request->query('test_guide_id') ?? $request->query('guide_id');
        $guides = TestGuide::with('test')->orderBy('title', 'asc')->get();

        // Calculate next sort order automatically
        $nextSortOrder = 1;
        if ($guideId) {
            $nextSortOrder = TestGuideSection::where('test_guide_id', $guideId)->max('sort_order') + 1;
        }

        return view('admin.guide-sections.create', compact('guides', 'guideId', 'nextSortOrder'));
    }

    /**
     * Store a newly created section in storage.
     */
    public function store(TestGuideSectionRequest $request)
    {
        try {
            DB::beginTransaction();

            $section = TestGuideSection::create($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.guides.edit', $section->test_guide_id)
                ->with('success', "Bagian panduan \"{$section->section_title}\" berhasil ditambahkan!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan section panduan: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan bagian panduan.');
        }
    }

    /**
     * Display the specified section.
     */
    public function show(TestGuideSection $testGuideSection)
    {
        return redirect()->route('superadmin.guides.edit', $testGuideSection->test_guide_id);
    }

    /**
     * Show the form for editing the specified section.
     */
    public function edit(TestGuideSection $testGuideSection)
    {
        $testGuideSection->load('guide');
        $guides = TestGuide::with('test')->orderBy('title', 'asc')->get();

        return view('admin.guide-sections.edit', compact('testGuideSection', 'guides'));
    }

    /**
     * Update the specified section in storage.
     */
    public function update(TestGuideSectionRequest $request, TestGuideSection $testGuideSection)
    {
        try {
            DB::beginTransaction();

            $testGuideSection->update($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.guides.edit', $testGuideSection->test_guide_id)
                ->with('success', "Bagian panduan \"{$testGuideSection->section_title}\" berhasil diperbarui!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui section panduan: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui bagian panduan.');
        }
    }

    /**
     * Remove the specified section from storage.
     */
    public function destroy(TestGuideSection $testGuideSection)
    {
        try {
            DB::beginTransaction();

            $title = $testGuideSection->section_title;
            $guideId = $testGuideSection->test_guide_id;

            $testGuideSection->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.guides.edit', $guideId)
                ->with('success', "Bagian panduan \"{$title}\" berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus section panduan: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menghapus bagian panduan.');
        }
    }
}
