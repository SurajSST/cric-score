<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    // Registration function
    public function register(Request $request)
    {
        // Validation rules for registration
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'password' => 'required|string|min:8',
        ]);

        // Create a new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password), // Hash the password for security
        ]);

        // Optionally, you can login the user after registration
        Auth::login($user);

        return response()->json(['message' => 'Registration successful', 'user' => $user]);
    }

    // Login function
    public function login(Request $request)
    {
        // Validation rules for login
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Attempt to log in the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentication successful
            $user = Auth::user();
            $token = $user->createToken('secret')->accessToken;

            return response()->json(['message' => 'Login successful', 'user' => $user, 'access_token' => $token]);
        } else {
            // Authentication failed
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
    }
}
