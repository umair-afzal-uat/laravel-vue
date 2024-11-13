<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the authenticated user exists and their role is 'admin' or if the user ID is 1
        if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->id === 1)) {
            return $next($request);
        }

        // Return unauthorized response if the user is not an admin or does not have ID 1
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized access. Admins only.',
        ], Response::HTTP_FORBIDDEN); // Using Symfony constant for HTTP status
    }
}
