<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RedirectBasedOnRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Get the current authenticated user
        $user = auth()->user();

        // Check if the user is logged in
        if ($user) {
            // Clear all previous session data or routes
            Session::flush(); // This will clear all session data

            // Check the user's role and redirect to the appropriate dashboard
              switch ($user->role->role_title) {
            case 'developer':
                return redirect()->route('developer.index');
            case 'superadmin':
                return redirect()->route('superadmin.dashboard');
            case 'admin':
                return redirect()->route('admin.dashboard');
            case 'user':
                return redirect()->route('home');
            default:
                return redirect()->route('login'); // Redirect to login if role doesn't exist
        }
        }

        // Proceed with the request if the user is not logged in or role doesn't match
        return $next($request);
    }
}
