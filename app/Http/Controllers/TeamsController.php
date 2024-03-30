<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;

class TeamsController extends Controller
{
    // Index - Get all teams
    public function index()
    {
        return Team::all();
    }

    // Show - Get a specific team by ID
    public function show($id)
    {
        return Team::findOrFail($id);
    }

    // Store - Create a new team
    public function store(Request $request)
    {
        $team = Team::create($request->all());
        return response()->json($team, 201);
    }

    // Update - Update a team by ID
    public function update(Request $request, $id)
    {
        $team = Team::findOrFail($id);
        $team->update($request->all());
        return response()->json($team, 200);
    }

    // Destroy - Delete a team by ID
    public function destroy($id)
    {
        Team::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
