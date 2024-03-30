<?php

namespace App\Http\Controllers;

use App\Models\MatchStatistic;
use Illuminate\Http\Request;

class MatchStatisticsController extends Controller
{
    // Index - Get all match statistics
    public function index()
    {
        return MatchStatistic::all();
    }

    // Show - Get specific match statistics by ID
    public function show($id)
    {
        return MatchStatistic::findOrFail($id);
    }

    // Store - Create new match statistics
    public function store(Request $request)
    {
        $matchStatistic = MatchStatistic::create($request->all());
        return response()->json($matchStatistic, 201);
    }

    // Update - Update match statistics by ID
    public function update(Request $request, $id)
    {
        $matchStatistic = MatchStatistic::findOrFail($id);
        $matchStatistic->update($request->all());
        return response()->json($matchStatistic, 200);
    }

    // Destroy - Delete match statistics by ID
    public function destroy($id)
    {
        MatchStatistic::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
