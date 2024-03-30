<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;

class PlayersController extends Controller
{
    // Index - Get all players
    public function index()
    {
        return Player::all();
    }

    // Show - Get a specific player by ID
    public function show($id)
    {
        return Player::findOrFail($id);
    }

    // Store - Create a new player
    public function store(Request $request)
    {
        $player = Player::create($request->all());
        return response()->json($player, 201);
    }

    // Update - Update a player by ID
    public function update(Request $request, $id)
    {
        $player = Player::findOrFail($id);
        $player->update($request->all());
        return response()->json($player, 200);
    }

    // Destroy - Delete a player by ID
    public function destroy($id)
    {
        Player::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
