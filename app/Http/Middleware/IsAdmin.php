<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class IsAdmin
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

            if ($user) {
                $roleTitle = DB::table('roles')
                    ->where('id', $user->role_id)
                    ->value('role_title');

                if ($roleTitle === 'admin' || $roleTitle === 'superadmin' || $roleTitle === 'developer'  ) {
                    return $next($request);
                }
            }

            abort(403, 'Unauthorized');
        }


}
