<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use App\Models\User;
use App\Models\Plan;
use App\Models\Subscription;

use App\Models\Company;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

        public function devDashboard(){
            return view('developer.index');
        }


    
  public function showCreateForm()
    {
        return view('developer.create_super_admin');
    }
public function storeSuperAdmin(Request $request)
{
    // Validate the form inputs
    $request->validate([
        'company_name' => 'required|string|max:255',
        'company_email' => 'required|string|email|max:255|unique:companies,company_email',
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'phone' => 'required|string',
    ]);

    // Create the Super Admin company (production company)
    $company = Company::create([
        'company_name' => $request->company_name,
        'company_email' => $request->company_email,
        'company_phone' => $request->company_phone,
    ]);

    // Create the Super Admin user account
    $superAdmin = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make('74108520'), // Default password, you can change this
        'role_id' => 3, // Super Admin role (assuming 3 is the role for Super Admin)
        'company_id' => $company->id, // Link to the company
    ]);

    // Retrieve the "Free" plan
    $freePlan = Plan::where('id', 1)->first(); // Ensure you have a plan named "Free"
    // dd($freePlan);

    if ($freePlan) {
        // Create a subscription record for the new super admin
        Subscription::create([
            'company_id' => $company->id,          // Link the subscription to the company
            'plan_id' => $freePlan->id,            // Assign the Free plan ID
            'subscription_start' => now(),          // Set the subscription start date to the current date
            'subscription_end' => now()->addYear(), // Set the subscription end date to 1 year from now
            'payment_status' => 'paid',             // Mark the subscription as paid since it's the Free plan
            'cinema_count' => $freePlan->cinema_count, // Set the cinema_count from the Free plan
            'active' => 1,                          // Mark as active
            'stripe_subscription_id' => $freePlan->stripe_plan_id, // Store the Stripe Plan ID
            'stripe_price_id' => $freePlan->stripe_price_id, // Store the Stripe Plan ID
            'status' => 'active'// Store the Stripe Plan ID
        ]);
    }

    // Flash a success message
    session()->flash('success', 'Super Admin created successfully!');

    // Redirect to the developer dashboard or home
    return redirect()->route('home')->with('success', 'Super Admin and subscription created successfully.');
}


}
