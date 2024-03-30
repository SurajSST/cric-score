<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    // Index - Get all notifications
    public function index()
    {
        return Notification::all();
    }

    // Show - Get specific notification by ID
    public function show($id)
    {
        return Notification::findOrFail($id);
    }

    // Store - Create new notification
    public function store(Request $request)
    {
        $notification = Notification::create($request->all());
        return response()->json($notification, 201);
    }

    // Update - Update notification by ID
    public function update(Request $request, $id)
    {
        $notification = Notification::findOrFail($id);
        $notification->update($request->all());
        return response()->json($notification, 200);
    }

    // Destroy - Delete notification by ID
    public function destroy($id)
    {
        Notification::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
