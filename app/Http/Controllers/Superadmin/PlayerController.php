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
        $search = $request->query('search');

        $query = Player::with(['coach'])->withCount('assessments');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhereHas('coach', function ($cq) use ($search) {
                      $cq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $players = $query->orderBy('name', 'asc')->paginate(10);

        return view('admin.players.index', compact('players', 'search'));
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
