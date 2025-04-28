<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        
        return view('auth.register');  // Make sure the register view has a field for phone number
    }

    public function register(Request $request)
    {
        // Validation
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|regex:/^01[0-9]{9}$/|unique:users,phone', // Validate phone number format and uniqueness
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,  // Store phone number
            'password' => Hash::make($request->password),
        ]);

 
        $user->role_id = 1; 
        $user->save();

        // Log the user in
        Auth::login($user);

        // Redirect based on role
        return redirect('/');
    }

  
}
