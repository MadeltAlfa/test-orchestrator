<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\PlayerProfile;
use App\Models\User;
use App\Http\Requests\Superadmin\PlayerProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlayerProfileController extends Controller
{
    /**
     * Display a listing of player profiles with pagination.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = PlayerProfile::with('user');

        if ($search) {
            $query->where('full_name', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('email', 'like', "%{$search}%");
                });
        }

        $profiles = $query->orderBy('full_name', 'asc')
            ->paginate(10);

        return view('admin.player-profiles.index', compact('profiles', 'search'));
    }

    /**
     * Display the specified player profile.
     */
    public function show(PlayerProfile $playerProfile)
    {
        $playerProfile->load(['user.assessments' => function ($query) {
            $query->with('finalPosition')->orderBy('created_at', 'desc');
        }]);

        return view('admin.player-profiles.show', compact('playerProfile'));
    }

    /**
     * Show the form for editing the specified player profile.
     */
    public function edit(PlayerProfile $playerProfile)
    {
        $playerProfile->load('user');
        return view('admin.player-profiles.edit', compact('playerProfile'));
    }

    /**
     * Update the specified player profile in storage.
     */
    public function update(PlayerProfileRequest $request, PlayerProfile $playerProfile)
    {
        try {
            DB::beginTransaction();

            $playerProfile->update($request->validated());

            DB::commit();

            return redirect()
                ->route('superadmin.player-profiles.show', $playerProfile->id)
                ->with('success', "Biodata pemain {$playerProfile->full_name} berhasil diperbarui!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui profil pemain: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui biodata pemain.');
        }
    }

    /**
     * Remove the specified player profile from storage.
     */
    public function destroy(PlayerProfile $playerProfile)
    {
        try {
            DB::beginTransaction();

            $fullName = $playerProfile->full_name;
            $playerProfile->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.player-profiles.index')
                ->with('success', "Biodata pemain {$fullName} berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus profil pemain: ' . $e->getMessage());

            return redirect()
                ->route('superadmin.player-profiles.index')
                ->with('error', 'Terjadi kesalahan saat menghapus biodata pemain.');
        }
    }
}
