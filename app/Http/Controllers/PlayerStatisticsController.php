<?php

namespace App\Http\Controllers;

use App\Models\PlayerStatistic;
use Illuminate\Http\Request;

class PlayerStatisticsController extends Controller
{
    // Index - Get all player statistics
    public function index()
    {
        return PlayerStatistic::all();
    }

    // Show - Get specific player statistics by ID
    public function show($id)
    {
        return PlayerStatistic::findOrFail($id);
    }

    // Store - Create new player statistics
    public function store(Request $request)
    {
        $playerStatistic = PlayerStatistic::create($request->all());
        return response()->json($playerStatistic, 201);
    }

    // Update - Update player statistics by ID
    public function update(Request $request, $id)
    {
        $playerStatistic = PlayerStatistic::findOrFail($id);
        $playerStatistic->update($request->all());
        return response()->json($playerStatistic, 200);
    }

    // Destroy - Delete player statistics by ID
    public function destroy($id)
    {
        PlayerStatistic::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
