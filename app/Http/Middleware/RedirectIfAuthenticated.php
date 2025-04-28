<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::guard($guard)->user();
                $roleTitle = DB::table('roles')->where('id', $user->role_id)->value('role_title');

                switch ($roleTitle) {
                    case 'developer':
                        return redirect()->route('developer.index');
                    case 'superadmin':
                        return redirect()->route('superadmin.dashboard');
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'staff':
                        return redirect()->route('staff.dashboard');
                    case 'user':
                        return redirect()->route('user.dashboard');
                    default:
                        return redirect(RouteServiceProvider::HOME);
                }
            }
        }

        return $next($request);
    }
}