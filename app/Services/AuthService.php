<?php

namespace App\Services;

use App\Events\UserActionEvent;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;

class AuthService
{
    /** 
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * AuthService constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Register a new user and trigger an event for user registration.
     *
     * @param array $data - The data to create a new user.
     * @param string $ip - The IP address from where the request originated.
     * 
     * @return User - The created user instance.
     */
    public function register(array $data, string $ip): User
    {
        // Create user
        $user = $this->userRepository->createUser($data);

        // Log the user action (user registration)
        event(new UserActionEvent($user, 'User Register', 'User Registered successfully', $ip));

        return $user;
    }

    /**
     * Login a user, attempt to authenticate, and trigger a login event.
     *
     * @param array $credentials - The credentials (email and password) for logging in.
     * @param string $ip - The IP address from where the request originated.
     * 
     * @throws ValidationException - If the authentication fails.
     * 
     * @return User - The authenticated user instance.
     */
    public function login(array $credentials, string $ip): User
    {
        // Attempt to authenticate the user with provided credentials
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        // Get the authenticated user
        $user = Auth::user();

        // Log the user action (user login)
        event(new UserActionEvent($user, 'User Login', 'User logged in successfully', $ip));

        return $user;
    }

    /**
     * Logout the user by revoking their API tokens and trigger a logout event.
     *
     * @param string $ip - The IP address from where the request originated.
     * 
     * @return User - The authenticated user instance after logout.
     */
    public function logout(string $ip): User
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Revoke the user's token(s)
        $user->tokens->each(function ($token) {
            $token->delete();
        });

        // Log the user action (user logout)
        event(new UserActionEvent($user, 'User Logout', 'User Logged out successfully', $ip));

        return $user;
    }

    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return User|null
     */
    public function findUserById(int $id)
    {
        return $this->userRepository->find($id);
    }
    /**
     * Update the user profile.
     *
     * @param  \App\Models\User  $user
     * @param  array  $data
     * @return bool
     */
    public function updateProfile(User $user, array $data)
    {
        // Perform the update using the repository
        return $this->userRepository->update($user, $data);
    }
}
