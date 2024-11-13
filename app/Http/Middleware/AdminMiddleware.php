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
        // Check if the authenticated user has an 'admin' role (or if user is admin by other means)
        if (auth()->check() && auth()->user()->role === 'admin') {
            return $next($request);
        }

        // Return unauthorized response if the user is not an admin
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized access. Admins only.',
        ], Response::HTTP_FORBIDDEN); // Using Symfony constant for HTTP status
    }
}
