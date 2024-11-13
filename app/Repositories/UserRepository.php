<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * Create a new user in the database.
     *
     * @param array $data - The data for creating the user, including name, email, and password.
     * 
     * @return User - The created user instance.
     */
    public function createUser(array $data): User
    {
        // Create and return the new user with hashed password
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    /**
     * Find a user by their email address.
     *
     * @param string $email - The email of the user to be retrieved.
     * 
     * @return User|null - The user instance if found, otherwise null.
     */
    public function findUserByEmail(string $email): ?User
    {
        // Find and return the user by email, or null if not found
        return User::where('email', $email)->first();
    }
    /**
     * Find a user by their ID.
     *
     * @param  int  $id
     * @return \App\Models\User|null
     */
    public function find($id)
    {
        return User::find($id);
    }

    /**
     * Update the user profile.
     *
     * @param  \App\Models\User  $user
     * @param  array  $data
     * @return bool
     */
    public function update(User $user, array $data)
    {
        return $user->update($data);
    }
}
