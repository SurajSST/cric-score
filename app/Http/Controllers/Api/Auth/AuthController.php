<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Laravel\Fortify\Rules\Password as FortifyPassword;
use App\Http\Controllers\Api\Auth\Swift_TransportException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'code' => 400 // Bad Request
            ], 400);
        }

        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user();
            $userDetails = [
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
                'dob' => $user->dob,
                'phone' => $user->phone,
                'address' => $user->address,
                'profile_photo_path' => $user->profile_photo_path, // Assuming the avatar is stored as a URL
                'playerType' => $user->playerType,
            ];

            return response()->json([
                'token' => $user->createToken('auth-token')->plainTextToken,
                'user' => $userDetails,
            ]);
        }

        return response()->json([
            'error' => 'Invalid credentials',
            'code' => 401 // Unauthorized
        ], 401);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|email|unique:users',
            'dob' => 'required|date',
            'phone' => 'required|string',
            'password' => 'required|min:8',
            'address' => 'required|string',
            'playerType' => 'nullable|string' // Make playerType optional
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'code' => 400 // Bad Request
            ], 400);
        }

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'dob' => $request->dob,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'address' => $request->address,
            'playerType' => $request->input('playerType', 'Batsman'), // Set default value if not provided
        ]);

        return response()->json([
            'token' => $user->createToken('auth-token')->plainTextToken,
            'user' => $user->only('name', 'username', 'email', 'dob', 'phone', 'address', 'playerType'), // Return user object from database
        ]);
    }


    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'code' => 400 // Bad Request
            ], 400);
        }

        try {
            $status = Password::sendResetLink($request->only('email'));

            if ($status === Password::RESET_LINK_SENT) {
                return response()->json([
                    'message' => 'Password reset link sent to your email address',
                ]);
            } else {
                return response()->json([
                    'error' => trans($status),
                    'code' => 400 // Bad Request
                ], 400);
            }
        } catch (\Exception $e) {
            // Error occurred while sending email
            return response()->json([
                'error' => 'Failed to send password reset email. Please try again later.',
                'code' => 500 // Internal Server Error
            ], 500);
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => ['required', new FortifyPassword],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()->first(),
                'code' => 400 // Bad Request
            ], 400);
        }

        $status = Password::reset(
            $request->only('email', 'password', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => bcrypt($password),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return response()->json([
                'message' => 'Password has been reset successfully',
            ]);
        } else {
            return response()->json([
                'error' => trans($status),
                'code' => 400 // Bad Request
            ], 400);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
