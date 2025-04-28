<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IsUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if ($user) {
            // Get the role title from the roles table based on the user's role_id
            $roleTitle = DB::table('roles')
                ->where('id', $user->role_id)
                ->value('role_title');

            // Define allowed roles
            $allowedRoles = ['admin', 'superadmin', 'user', 'staff' , 'developer'];

            // Check if the user's role is in the allowed roles
            if (in_array($roleTitle, $allowedRoles)) {
                return $next($request);
            }
        }

        // If the user is not allowed, abort with a 403 error
        abort(403, 'Unauthorized access');
    }
}
