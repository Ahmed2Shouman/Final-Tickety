<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeveloperAccess
{
    public function handle(Request $request, Closure $next)
    {
        // Check if the logged-in user has the developer role
        if (Auth::check() && Auth::user()->role_id === 5) { // Assuming role_id 1 is the developer
            return $next($request); // Grant access if user is developer
        }

        // If the user is not the developer, redirect them with an error message
        return redirect()->route('home')->with('error', 'Access denied: You do not have permission to create Super Admins.');
    }
}
