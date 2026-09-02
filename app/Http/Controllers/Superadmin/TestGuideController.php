<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\TestGuide;
use App\Models\SkillTest;
use App\Http\Requests\Superadmin\TestGuideRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TestGuideController extends Controller
{
    /**
     * Display a listing of test guides with pagination.
     */
    public function index()
    {
        $guides = TestGuide::with('test')
            ->withCount('sections')
            ->orderBy('title', 'asc')
            ->paginate(10);

        return view('admin.guides.index', compact('guides'));
    }

    /**
     * Show the form for creating a new test guide.
     */
    public function create()
    {
        // Only allow guides for tests that do not have a guide yet
        $existingGuideTestIds = TestGuide::pluck('test_id')->toArray();
        $tests = SkillTest::whereNotIn('id', $existingGuideTestIds)
            ->orderBy('name', 'asc')
            ->get();

        return view('admin.guides.create', compact('tests'));
    }

    /**
     * Store a newly created test guide in storage.
     */
    public function store(TestGuideRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('guides', 'public');
                $validated['image'] = $path;
            }

            $guide = TestGuide::create($validated);

            DB::commit();

            return redirect()
                ->route('superadmin.guides.edit', $guide)
                ->with('success', "Panduan untuk tes {$guide->test->name} berhasil dibuat! Silakan kelola bagian panduan (sections).");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan panduan tes: ' . $e->getMessage());

            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan panduan tes.');
        }
    }

    /**
     * Display the specified test guide (redirect to unified edit/manage page).
     */
    public function show(TestGuide $testGuide)
    {
        return redirect()->route('superadmin.guides.edit', $testGuide);
    }

    /**
     * Show the unified form for editing test guide and managing sections.
     */
    public function edit(TestGuide $testGuide)
    {
        $testGuide->load(['test', 'sections']);
        $tests = SkillTest::orderBy('name', 'asc')->get();

        return view('admin.guides.edit', compact('testGuide', 'tests'));
    }

    /**
     * Update the specified test guide in storage.
     */
    public function update(TestGuideRequest $request, TestGuide $testGuide)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $oldImagePath = $testGuide->image;

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('guides', 'public');
                $validated['image'] = $path;

                // Delete old image if exists
                if ($oldImagePath) {
                    Storage::disk('public')->delete($oldImagePath);
                }
            }

            $testGuide->update($validated);

            DB::commit();

            return redirect()
                ->route('superadmin.guides.edit', $testGuide)
                ->with('success', "Informasi panduan tes berhasil diperbarui!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui panduan tes: ' . $e->getMessage());

            if (isset($path)) {
                Storage::disk('public')->delete($path);
            }

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui panduan tes.');
        }
    }

    /**
     * Remove the specified test guide from storage.
     */
    public function destroy(TestGuide $testGuide)
    {
        try {
            DB::beginTransaction();

            $title = $testGuide->title;
            $imagePath = $testGuide->image;

            $testGuide->delete();

            if ($imagePath) {
                Storage::disk('public')->delete($imagePath);
            }

            DB::commit();

            return redirect()
                ->route('superadmin.guides.index')
                ->with('success', "Panduan \"{$title}\" berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus panduan tes: ' . $e->getMessage());

            return redirect()
                ->route('superadmin.guides.index')
                ->with('error', 'Terjadi kesalahan saat menghapus panduan tes.');
        }
    }
}
