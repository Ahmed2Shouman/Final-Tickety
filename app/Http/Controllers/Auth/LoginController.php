<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
public function showLoginForm()
{
    if (Auth::check()) {
        return redirect($this->redirectPath());
    }

    return response()
        ->view('auth.login')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, post-check=0, pre-check=0')
        ->header('Pragma', 'no-cache')
        ->header('Expires', '0');
}

    public function login(Request $request)
    {
        // Validate the credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Get the credentials
        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            // Use the redirectPath method to get the correct redirect route based on the user's role
            return redirect()->intended($this->redirectPath());
        }

        // If login failed, redirect back with an error message
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    /**
     * Get the redirect path based on user role.
     *
     * @return string
     */
    protected function redirectPath()
    {
        // Fetch the authenticated user
        $user = Auth::user();

        // If user is authenticated, check the role
        if ($user) {
            // Fetch the role_title using role_id
            $roleTitle = DB::table('roles')
                ->where('id', $user->role_id)
                ->value('role_title');

            // Redirect based on the role
            switch ($roleTitle) {
                case 'admin':
                    return route('admin.dashboard');
                case 'superadmin':
                    return route('superadmin.dashboard');
                case 'staff':
                    return route('staff.dashboard');
                default:
                    return route('home');
            }
        }

        // Default redirect if no role found (fallback)
        return route('home');
    }
}



