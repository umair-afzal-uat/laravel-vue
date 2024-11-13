<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthRequest extends FormRequest
{

    public function rules()
    {
        // Check if the current route is for login or registration
        if ($this->routeIs('login')) {
            // Login request
            return $this->loginRules();
        }

        // Default to registration rules for other requests (such as POST requests to 'register' route)
        return $this->registrationRules();
    }

    // Validation rules for the registration process
    protected function registrationRules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ];
    }

    // Validation rules for the login process
    protected function loginRules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }
}
