<?php

declare(strict_types=1);

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UserProfileRequest;
use App\Models\PlayerProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
    public function index()
    {
        $user = auth()->user();
        $profile = $user->playerProfile;

        return view('user.profile.index', compact('user', 'profile'));
    }

    /**
     * Show the form for editing the profile.
     */
    public function edit()
    {
        $user = auth()->user();
        $profile = $user->playerProfile;

        return view('user.profile.edit', compact('user', 'profile'));
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(UserProfileRequest $request)
    {
        $user = auth()->user();

        try {
            DB::beginTransaction();

            $profile = PlayerProfile::updateOrCreate(
                ['user_id' => $user->id],
                $request->validated()
            );

            DB::commit();

            return redirect()
                ->route('user.profile.index')
                ->with('success', 'Profil biodata pemain berhasil diperbarui!');
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui profil pemain user: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan biodata. Silakan coba lagi.');
        }
    }
}
