<?php

declare(strict_types=1);

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\Controller;
use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PlayerController extends Controller
{
    /**
     * Display a listing of all players managed across all coaches.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'sort' => ['nullable', 'string', 'in:name,created_at'],
            'order' => ['nullable', 'string', 'in:asc,desc'],
        ]);

        $search = $validated['search'] ?? null;
        $sort = $validated['sort'] ?? 'name';
        $order = $validated['order'] ?? 'asc';

        // Eager load menutup N+1: players + coach + profile + position + count = 4 query total.
        $query = Player::with(['coach', 'profile.position'])->withCount('assessments');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('coach', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $data = $query->orderBy($sort, $order)->paginate(15)->withQueryString();

        if ($request->wantsJson()) {
            return response()->json($data);
        }

        return view('superadmin.players.index', compact('data', 'search', 'sort', 'order'));
    }

    /**
     * Display detailed player info and assessment history.
     */
    public function show(Player $player)
    {
        $player->load([
            'coach',
            'assessments' => function ($q) {
                $q->with('finalPosition')->orderBy('assessment_date', 'desc')->orderBy('created_at', 'desc');
            }
        ]);

        return view('admin.players.show', compact('player'));
    }

    /**
     * Remove the specified player.
     */
    public function destroy(Player $player)
    {
        try {
            DB::beginTransaction();

            $playerName = $player->name;
            $player->delete();

            DB::commit();

            return redirect()
                ->route('superadmin.players.index')
                ->with('success', "Data pemain {$playerName} berhasil dihapus!");
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Gagal menghapus data pemain: ' . $e->getMessage());

            return redirect()
                ->route('superadmin.players.index')
                ->with('error', 'Terjadi kesalahan saat menghapus data pemain.');
        }
    }
}
