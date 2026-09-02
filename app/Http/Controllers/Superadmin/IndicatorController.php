<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Indicator;
use App\Http\Requests\Superadmin\IndicatorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IndicatorController extends Controller
{
    /**
     * Display a listing of indicators with pagination.
     */
    public function index()
    {
        $indicators = Indicator::with(['tests'])
            ->withCount(['positions', 'tests'])
            ->orderBy('code', 'asc')
            ->paginate(10);

        return view('admin.indicators.index', compact('indicators'));
    }

    /**
     * Show the form for creating a new indicator.
     */
    public function create()
    {
        return view('admin.indicators.create');
    }

    /**
     * Store a newly created indicator in storage.
     */
    public function store(IndicatorRequest $request)
    {
        try {
            DB::beginTransaction();

            $indicator = Indicator::create($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.indicators.index')
                ->with('success', "Indikator {$indicator->name} berhasil ditambahkan!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan indikator: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan indikator. Coba lagi.');
        }
    }

    /**
     * Display the specified indicator.
     */
    public function show(Indicator $indicator)
    {
        $indicator->load(['positions', 'tests']);

        return view('admin.indicators.show', compact('indicator'));
    }

    /**
     * Show the form for editing the specified indicator.
     */
    public function edit(Indicator $indicator)
    {
        return view('admin.indicators.edit', compact('indicator'));
    }

    /**
     * Update the specified indicator in storage.
     */
    public function update(IndicatorRequest $request, Indicator $indicator)
    {
        try {
            DB::beginTransaction();

            $indicator->update($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.indicators.index')
                ->with('success', "Indikator {$indicator->name} berhasil diperbarui!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui indikator: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui indikator. Coba lagi.');
        }
    }

    /**
     * Remove the specified indicator from storage.
     */
    public function destroy(Indicator $indicator)
    {
        try {
            DB::beginTransaction();

            $indicatorName = $indicator->name;
            $indicator->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.indicators.index')
                ->with('success', "Indikator {$indicatorName} berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus indikator: ' . $e->getMessage());

            return redirect()
                ->route('superadmin.indicators.index')
                ->with('error', 'Terjadi kesalahan saat menghapus indikator. Pastikan indikator tidak sedang digunakan.');
        }
    }
}
