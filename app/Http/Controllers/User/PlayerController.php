<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Player;

class PlayerController extends Controller
{
    public function index()
    {
        $players = auth()->user()->players()->orderBy('name')->get();
        return view('user.players.index', compact('players'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
        ]);

        auth()->user()->players()->create($validated);

        return back()->with('success', 'Pemain berhasil ditambahkan.');
    }

    public function update(Request $request, Player $player)
    {
        if ($player->coach_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'dob' => 'required|date',
        ]);

        $player->update($validated);

        return back()->with('success', 'Data pemain berhasil diupdate.');
    }

    public function show(Player $player)
    {
        if ($player->coach_id !== auth()->id()) {
            abort(403);
        }

        $assessments = $player->assessments()
            ->with(['finalPosition'])
            ->orderBy('assessment_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.players.show', compact('player', 'assessments'));
    }

    public function destroy(Player $player)
    {
        if ($player->coach_id !== auth()->id()) {
            abort(403);
        }

        $player->delete();

        return redirect()->route('user.players.index')->with('success', 'Pemain berhasil dihapus.');
    }
}
