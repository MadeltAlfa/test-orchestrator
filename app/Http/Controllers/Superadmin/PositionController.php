<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Position;
use App\Http\Requests\Superadmin\PositionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PositionController extends Controller
{
    /**
     * Display a listing of positions with pagination.
     */
    public function index()
    {
        $positions = Position::withCount('indicators')
            ->orderBy('code', 'asc')
            ->paginate(10);

        return view('admin.positions.index', compact('positions'));
    }

    /**
     * Show the form for creating a new position.
     */
    public function create()
    {
        return view('admin.positions.create');
    }

    /**
     * Store a newly created position in storage.
     */
    public function store(PositionRequest $request)
    {
        try {
            DB::beginTransaction();

            $position = Position::create($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.positions.index')
                ->with('success', "Posisi {$position->name} berhasil ditambahkan!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menambahkan posisi: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan posisi. Coba lagi.');
        }
    }

    /**
     * Display the specified position along with its indicators.
     */
    public function show(Position $position)
    {
        $position->load(['indicators' => function ($query) {
            $query->orderBy('code', 'asc');
        }]);

        return view('admin.positions.show', compact('position'));
    }

    /**
     * Show the form for editing the specified position.
     */
    public function edit(Position $position)
    {
        return view('admin.positions.edit', compact('position'));
    }

    /**
     * Update the specified position in storage.
     */
    public function update(PositionRequest $request, Position $position)
    {
        try {
            DB::beginTransaction();

            $position->update($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.positions.index')
                ->with('success', "Posisi {$position->name} berhasil diperbarui!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui posisi: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui posisi. Coba lagi.');
        }
    }

    /**
     * Remove the specified position from storage.
     */
    public function destroy(Position $position)
    {
        try {
            DB::beginTransaction();

            $positionName = $position->name;
            $position->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.positions.index')
                ->with('success', "Posisi {$positionName} berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus posisi: ' . $e->getMessage());

            return redirect()
                ->route('superadmin.positions.index')
                ->with('error', 'Terjadi kesalahan saat menghapus posisi. Pastikan posisi tidak sedang digunakan.');
        }
    }
}
