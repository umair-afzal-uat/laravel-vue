<?php

namespace App\Http\Controllers;

use App\Events\UserActionEvent;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        // Validate the request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new UserActionEvent($user, 'User Register', 'User Registerred successfully', $request->ip()));
        // Return a success response with the user's data
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user
        ]);
    }

    /**
     * Login a user and return an authentication token.
     */
    public function login(Request $request)
    {
        // Validate the login credentials
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Check if the credentials are correct
        if (!Auth::attempt($validated)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Create an API token for the user
        $token = $user->createToken('API Token')->plainTextToken;

        event(new UserActionEvent($user, 'User Login', 'User logged in successfully', $request->ip()));
        // Return the token in the response
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }

    /**
     * Logout the user by invalidating the token.
     */
    public function logout(Request $request)
    {
        // Revoke the user's token
        $request->user()->tokens->each(function ($token) {
            $token->delete();
        });

        event(new UserActionEvent($request->user(), 'User Logout', 'User Logged out successfully', $request->ip()));
        return response()->json(['message' => 'Logged out successfully']);
    }
}
