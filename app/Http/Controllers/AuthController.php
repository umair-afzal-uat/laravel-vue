<?php

namespace App\Http\Controllers;

use App\Events\UserActionEvent;
use App\Http\Requests\AuthRequest;
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
}
