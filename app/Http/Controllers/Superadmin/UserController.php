<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\Superadmin\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of the users with pagination and eager loading.
     * withCount('assessments') merges per-row COUNT into single query (no N+1).
     * Pencarian dibungkus closure where agar orWhere tidak merusak precedence AND/OR.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = User::with('playerProfile')->withCount('assessments');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderBy('name', 'asc')
            ->paginate(10);

        return view('admin.users.index', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $validated['password'] = Hash::make($validated['password']);

            $user = User::create($validated);

            DB::commit();

            return redirect()
                ->route('superadmin.users.index')
                ->with('success', "Akun pengguna {$user->name} berhasil disimpan!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan user: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan pengguna.');
        }
    }

    /**
     * Display the specified user along with their profile and assessments.
     */
    public function show(User $user)
    {
        $user->load(['playerProfile', 'assessments' => function ($query) {
            $query->with('finalPosition')->orderBy('created_at', 'desc');
        }]);

        $user->loadCount('assessments');

        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();

            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->update($validated);

            DB::commit();

            return redirect()
                ->route('superadmin.users.index')
                ->with('success', "Akun pengguna {$user->name} berhasil diperbarui!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal memperbarui user: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui pengguna.');
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            if (auth()->id() === $user->id) {
                DB::rollBack();

                return redirect()
                    ->route('superadmin.users.index')
                    ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
            }

            $userName = $user->name;
            $user->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.users.index')
                ->with('success', "Akun pengguna {$userName} berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus user: ' . $e->getMessage());

            return redirect()
                ->route('superadmin.users.index')
                ->with('error', 'Terjadi kesalahan saat menghapus pengguna.');
        }
    }
}
