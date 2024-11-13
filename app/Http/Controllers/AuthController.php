<?php

namespace App\Http\Controllers;

use App\Events\UserActionEvent;
use App\Http\Requests\AuthRequest;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /** 
     * @var AuthService
     */
    protected $authService;

    /**
     * AuthController constructor.
     *
     * @param AuthService $authService
     */
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     *
     * @param AuthRequest $request - The request containing the validated data for user registration.
     * 
     * @return \Illuminate\Http\JsonResponse - The response containing the success message and user data.
     */
    public function register(AuthRequest $request)
    {
        // Call the AuthService to register the user
        $user = $this->authService->register($request->validated(), $request->ip());

        // Return success response with the created user
        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ]);
    }

    /**
     * Login a user and return an authentication token.
     *
     * @param AuthRequest $request - The request containing the credentials for login.
     * 
     * @return \Illuminate\Http\JsonResponse - The response containing the success message and the generated token.
     */
    public function login(AuthRequest $request)
    {
        // Call the AuthService to login the user and get the user instance
        $user = $this->authService->login($request->validated(), $request->ip());

        // Generate an API token for the authenticated user
        $token = $user->createToken('API Token')->plainTextToken;

        // Return the success response with the token
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
        ]);
    }

    /**
     * Logout the user by invalidating the token.
     *
     * @param Request $request - The request containing user data for logout.
     * 
     * @return \Illuminate\Http\JsonResponse - The response with the logout success message.
     */
    public function logout(Request $request)
    {
        // Call the AuthService to handle user logout
        $this->authService->logout($request->ip());

        // Return success response indicating user has been logged out
        return response()->json(['message' => 'Logged out successfully']);
    }

    /**
     * Update the user profile.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile($id, Request $request)
    {
        // Find the user by ID
        $user = $this->authService->findUserById($id);

        // Ensure the user exists
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Update the user profile using the service
        $this->authService->updateProfile($user, $validated);

        // Fire the SystemEvent to log the profile update
        event(new UserActionEvent($user, 'Profile Updated', 'The user updated their profile.', $request->ip()));

        // Return a success response
        return response()->json(['message' => 'Profile updated successfully']);
    }
}
