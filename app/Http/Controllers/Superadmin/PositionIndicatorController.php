<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Models\Indicator;
use App\Models\PositionIndicator;
use App\Http\Requests\Superadmin\PositionIndicatorRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PositionIndicatorController extends Controller
{
    /**
     * Display a listing of indicators for a specific position.
     */
    public function index($positionId)
    {
        $position = Position::findOrFail($positionId);
        
        // Eager load associated indicators through pivot
        $position->load(['indicators' => function ($query) {
            $query->orderBy('code', 'asc');
        }]);

        // Get indicators that are not yet assigned to this position
        $assignedIndicatorIds = $position->indicators->pluck('id')->toArray();
        $availableIndicators = Indicator::whereNotIn('id', $assignedIndicatorIds)
            ->orderBy('code', 'asc')
            ->get();

        $positionIndicators = PositionIndicator::where('position_id', $positionId)
            ->with('indicator')
            ->get();

        return view('admin.position-indicators.index', compact('position', 'availableIndicators', 'positionIndicators'));
    }

    /**
     * Store a newly created position-indicator relation in storage.
     */
    public function store(PositionIndicatorRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            $position = Position::findOrFail($validated['position_id']);
            
            // Attach indicator with weight. We also manually pass UUID for 'id' primary key of pivot.
            $position->indicators()->attach($validated['indicator_id'], [
                'id' => (string) Str::uuid(),
                'weight' => $validated['weight'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('superadmin.position-indicators.index', $validated['position_id'])
                ->with('success', 'Indikator berhasil ditambahkan ke posisi dengan bobot yang ditentukan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan indikator ke posisi: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Pastikan indikator belum terhubung ke posisi ini.');
        }
    }

    /**
     * Update the weight in pivot table using dynamic route or model binding.
     */
    public function update(PositionIndicatorRequest $request, $id)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            
            $pivot = PositionIndicator::findOrFail($id);
            $pivot->update([
                'weight' => $validated['weight']
            ]);

            DB::commit();

            return redirect()
                ->route('superadmin.position-indicators.index', $pivot->position_id)
                ->with('success', 'Bobot indikator berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui bobot pivot: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat memperbarui bobot.');
        }
    }

    /**
     * Remove the relation from storage.
     */
    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $pivot = PositionIndicator::findOrFail($id);
            $positionId = $pivot->position_id;
            
            $pivot->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.position-indicators.index', $positionId)
                ->with('success', 'Indikator berhasil dilepas dari posisi!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus relasi posisi-indikator: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat melepas indikator dari posisi.');
        }
    }
}
