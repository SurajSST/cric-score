<?php

namespace App\Http\Controllers;

use App\Models\Matches;
use Illuminate\Http\Request;

class MatchesController extends Controller
{
    // Index - Get all matches
    public function index()
    {
        return Matches::all();
    }

    // Show - Get a specific match by ID
    public function show($id)
    {
        return Matches::findOrFail($id);
    }

    // Store - Create a new match
    public function store(Request $request)
    {
        $match = Matches::create($request->all());
        return response()->json($match, 201);
    }

    // Update - Update a match by ID
    public function update(Request $request, $id)
    {
        $match = Matches::findOrFail($id);
        $match->update($request->all());
        return response()->json($match, 200);
    }

    // Destroy - Delete a match by ID
    public function destroy($id)
    {
        Matches::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
