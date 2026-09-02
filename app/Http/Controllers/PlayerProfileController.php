<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerProfileController extends Controller
{
    public function index()
    {
        return 'Player profiles index';
    }

    public function create()
    {
        return 'Create player profile';
    }

    public function store(Request $request)
    {
        return redirect()->route('player-profiles.index');
    }

    public function show($id)
    {
        return "Player profile $id";
    }

    public function edit($id)
    {
        return "Edit player profile $id";
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('player-profiles.index');
    }

    public function destroy($id)
    {
        return redirect()->route('player-profiles.index');
    }
}
