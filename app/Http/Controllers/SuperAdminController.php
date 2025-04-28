<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Subscription;
use App\Models\Plan;
use App\Models\Company;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\SuperadminPayment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Checkout\Session;


class SuperAdminController extends Controller
{
    public function index()
    {
        return view('superadmin.dashboard');
    }

    public function createAdminForm()
    {
        return view('superadmin.manage_admins.create');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20|unique:users,phone|regex:/^01[0-9]{9}$/', // Validate phone starts with 01 and is 11 digits
            'salary' => 'required|numeric|min:0',  // Salary validation
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'salary' => $request->salary,  // Store the salary
            'password' => Hash::make('74108520'), // Default password
            'role_id' => 2,  // Admin role
        ]);

        return redirect()->route('superadmin.manage_admins.index')->with('success', 'Admin created successfully.');
    }

    public function viewAdmins()
    {
        $admins = User::where('role_id', 2)->get();  // Fetch all admins
        return view('superadmin.manage_admins.index', compact('admins'));
    }

    public function viewUsers()
    {
        $users = User::where('role_id', 1)->get();  // Fetch all regular users
        return view('superadmin.manage_users.index', compact('users'));
    }

    // Show form for updating admin profile
      public function editAdmin($id)
      {
         $admin = User::findOrFail($id);  // Fetch the admin by ID
         return view('superadmin.manage_admins.edit', compact('admin'));  // Pass the admin data to the edit view
      }


    // Handle updating admin data
 public function updateAdmin(Request $request, $id)
{
    // Validate the incoming data
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,  // Ignore the current admin email
        'phone' => 'required|string|max:20|unique:users,phone,' . $id,  // Ignore the current admin phone number
        'salary' => 'nullable|numeric|min:0',  // Optional salary field
    ]);

    // Find the admin to update
    $admin = User::findOrFail($id);

    // Update the admin details
    $admin->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'salary' => $request->salary,  // Update salary
    ]);

    // Redirect with success message
    return redirect()->route('superadmin.manage_admins.index')->with('success', 'Admin updated successfully!');
}

    // Handle deleting admin
public function deleteAdmin($id)
{
    $admin = User::findOrFail($id);  // Find the admin by ID
    $admin->delete();  // Delete the admin

    return redirect()->route('superadmin.manage_admins.index')->with('success', 'Admin deleted successfully!');
}


  public function profile()
{
    $superAdmin = Auth::user(); // Get the authenticated super admin user
    return view('superadmin.profile', compact('superAdmin'));
}




    
public function updateProfile(Request $request, $id)
{
    // Validate the incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Ensures the email is unique except for the current admin
        'phone' => 'required|string|max:20',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optionally handle image upload
    ]);

    // Find the Super Admin by ID
    $superadmin = User::findOrFail($id);

    // Update the Super Admin's profile
    $superadmin->name = $request->name;
    $superadmin->email = $request->email;
    $superadmin->phone = $request->phone;

    // Handle profile image upload (if any)
    if ($request->hasFile('profile_image')) {
        // Delete the old profile image if it exists
        if ($superadmin->profile_image) {
            $oldImagePath = public_path('storage/' . $superadmin->profile_image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image
            }
        }

        // Store the new image
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        // Update the profile image path in the database
        $superadmin->profile_image = $imagePath;
    }

    // Save the updated data
    $superadmin->save();

    // Redirect back to the profile page with a success message
    return redirect()->route('superadmin.profile')->with('success', 'Profile updated successfully!');
}

public function subscriptionSettings()
{
    $superAdmin = Auth::user();
    
    // Fetch the active subscription, if it exists
    $subscription = Subscription::where('company_id', $superAdmin->company_id)->first();
    
    // Fetch all available plans
    $plans = Plan::all();

    // Fetch subscription history from the SuperadminPayments table and eager load the plan associated with each payment
    $subscriptionHistory = SuperadminPayment::where('superadmin_id', $superAdmin->id)
        ->orderBy('paid_at', 'desc')  // Assuming 'paid_at' is the date when the payment was made
        ->with('plan')  // Eager load the 'plan' relationship
        ->get();

    // Pass subscription, plans, and subscription history to the view
    return view('superadmin.subscription_settings', compact('subscription', 'plans', 'subscriptionHistory'));
}





public function updateSubscription(Request $request, $planId)
{
    $superAdmin = Auth::user();

    // Fetch the current subscription
    $subscription = Subscription::where('company_id', $superAdmin->company_id)->first();
    
    if (!$subscription) {
        return redirect()->route('superadmin.subscription_settings')->with('error', 'No active subscription found.');
    }

    // Fetch the selected plan
    $plan = Plan::findOrFail($planId);

    // Create a temporary subscription entry with 'pending' payment status
    $subscription->plan_id = $plan->id;
    $subscription->payment_status = 'pending';  // Set payment status to pending
    $subscription->cinema_count = $plan->cinema_count;
    $subscription->subscription_end = now()->addYear(); // Extend the subscription end date
    $subscription->save();

    // Redirect to the payment gateway (e.g., Stripe)
    return $this->createStripeCheckoutSession($subscription);
}





public function createStripeCheckoutSession($subscription)
{
    // Set your Stripe secret key
    Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

    // Create the Stripe Checkout session
    $session = Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [
            [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $subscription->plan->name, // The plan name
                    ],
                    'unit_amount' => $subscription->plan->price * 100, // Stripe accepts amount in cents
                ],
                'quantity' => 1,
            ],
        ],
        'mode' => 'payment',
        'success_url' => route('superadmin.paymentSuccess', ['subscription' => $subscription->id]), // URL after payment success
        'cancel_url' => route('superadmin.paymentCancel'), // URL after payment failure
    ]);

    // Redirect the user to the Stripe Checkout session
    return redirect($session->url);
}



public function renewSubscription(Request $request)
{
    $superAdmin = Auth::user();
    $subscription = Subscription::where('company_id', $superAdmin->company_id)->first();

    if ($subscription) {
        // Renew the subscription by extending the subscription end date
        $subscription->subscription_end = now()->addYear();  // Add one year to the subscription
        $subscription->payment_status = 'paid';  // Update the payment status
        $subscription->save();

        return redirect()->route('superadmin.subscription_settings')->with('success', 'Subscription renewed successfully!');
    }

    return redirect()->route('superadmin.subscription_settings')->with('error', 'Subscription renewal failed!');
}


public function showPaymentView($planId)
{
    // Get the plan that the superadmin selected
    $plan = Plan::findOrFail($planId);

    // Get the current subscription to pass the details
    $subscription = Subscription::where('company_id', Auth::user()->company_id)->first();

    // Return the payment view with the plan and subscription details
    return view('superadmin.payment', compact('plan'));
}



public function checkout(Request $request, $planId)
{
    $plan = Plan::findOrFail($planId); // Find the chosen plan
    $planPrice = $plan->stripe_price_id; // Get the Stripe price ID associated with the plan
    $user = $request->user(); // Get the authenticated user

    // Create the Stripe Checkout session
    $session = \Stripe\Checkout\Session::create([
        'payment_method_types' => ['card'],
        'line_items' => [[
            'price' => $planPrice,
            'quantity' => 1,
        ]],
        'mode' => 'subscription',
        'customer_email' => $user->email,
        'success_url' => route('superadmin.checkout_success') . '?session_id={CHECKOUT_SESSION_ID}&plan_id=' . $planId, // Pass plan_id with the session_id
        'cancel_url' => route('superadmin.subscription_settings'),
    ]);

    // Redirect to Stripe Checkout
    return redirect($session->url);
}


public function checkoutSuccess(Request $request)
{
    // Retrieve session_id and plan_id from the query string
    $sessionId = $request->query('session_id');
    $planId = $request->query('plan_id');

    // Check if session_id and plan_id are provided
    if (!$sessionId || !$planId) {
        return redirect()->route('superadmin.subscription_settings')->with('error', 'Payment session ID or Plan ID not found.');
    }

    try {
        // Retrieve the session details from Stripe using session_id
        $session = \Stripe\Checkout\Session::retrieve($sessionId);

        // Ensure the payment is successful
        if ($session->payment_status == 'paid') {
            // Get the authenticated superadmin user
            $user = $request->user();

            // Retrieve the chosen plan from the database using plan_id
            $plan = Plan::findOrFail($planId); // Find the plan by ID

            // Retrieve subscription details from Stripe
            $subscription = \Stripe\Subscription::retrieve($session->subscription);

            // Find the current subscription record for the superadmin (if it exists)
            $userSubscription = Subscription::where('company_id', $user->company_id)->first();

            // Check if the superadmin already has a subscription
            if ($userSubscription) {
                // Update the existing subscription with the new plan details
                $userSubscription->plan_id = $plan->id;  // Set the plan_id
                $userSubscription->status = 'active';
                $userSubscription->active = 1;
                $userSubscription->subscription_start = \Carbon\Carbon::now(); // Current timestamp
                $userSubscription->subscription_end = \Carbon\Carbon::now()->addDays(30); // 30 days from now
                $userSubscription->stripe_subscription_id = $session->id; // Use the Stripe subscription ID
                $userSubscription->stripe_price_id = $plan->stripe_price_id; // Set the Stripe price ID
                $userSubscription->cinema_count = $plan->cinema_count; // Set the cinema count from the plan
                $userSubscription->save(); // Save the subscription record
            } else {
                // If no existing subscription, create a new one for the superadmin
                $newSubscription = new Subscription();
                $newSubscription->company_id = $user->company_id;
                $newSubscription->plan_id = $plan->id;  // Set the plan_id
                $newSubscription->subscription_start = \Carbon\Carbon::now(); // Current timestamp
                $newSubscription->subscription_end = \Carbon\Carbon::now()->addDays(30); // 30 days from now
                $newSubscription->payment_status = 'paid';
                $newSubscription->status = 'active';
                $newSubscription->stripe_subscription_id = $session->id; // Use the Stripe subscription ID
                $newSubscription->stripe_price_id = $plan->stripe_price_id; // Set the Stripe price ID
                $newSubscription->cinema_count = $plan->cinema_count; // Set the cinema count from the plan
                $newSubscription->save(); // Save the new subscription record
            }

            // Create a payment record in the SuperadminPayment table
            $payment = new SuperadminPayment();
            $payment->superadmin_id = $user->id;
            $payment->amount = $session->amount_total / 100; // Amount in dollars (Stripe returns amount in cents)
            $payment->currency = 'usd';
            $payment->status = 'paid';
            $payment->method = 'stripe';
            $payment->transaction_id = $session->id;
            $payment->stripe_receipt_url = $session->receipt_url;
            $payment->paid_at = \Carbon\Carbon::now();
            $payment->plan_id = $plan->id; // Associate the plan ID with the payment record
            $payment->save();

            // Redirect with success message
            return redirect()->route('superadmin.checkout_success')->with('success', 'Subscription successfully upgraded!');
        } else {
            // Handle cases where the payment was not completed
            return redirect()->route('superadmin.subscription_settings')->with('error', 'Payment was not completed.');
        }
    } catch (\Exception $e) {
        // Handle any errors (e.g., session retrieval failure)
        return redirect()->route('superadmin.subscription_settings')->with('error', 'Error fetching Stripe session: ' . $e->getMessage());
    }
}



public function subscriptionReport()
{
    // Get the subscriptions of the logged-in superadmin
    $superAdmin = Auth::user();
    $subscriptions = Subscription::where('company_id', $superAdmin->company_id)
                                 ->orderBy('subscription_end', 'desc')
                                 ->get();

    // Count active and expired subscriptions
    $activeSubscriptions = $subscriptions->where('payment_status', 'paid')->count();
    $expiredSubscriptions = $subscriptions->where('payment_status', 'pending')->count();

    return view('superadmin.report.subscription', compact('subscriptions', 'activeSubscriptions', 'expiredSubscriptions'));
}



public function revenueReport()
{
    $superAdmin = Auth::user();
    $subscriptions = Subscription::where('company_id', $superAdmin->company_id)
                                 ->where('payment_status', 'paid')
                                 ->get();

    // Calculate total revenue
    $totalRevenue = $subscriptions->sum('price');
    
    // Calculate revenue per plan
    $revenuePerPlan = $subscriptions->groupBy('plan_id')->map(function($planSubscriptions) {
        return $planSubscriptions->sum('price');
    });

    return view('superadmin.report.revenue', compact('totalRevenue', 'revenuePerPlan'));
}



public function usageReport()
{
    $superAdmin = Auth::user();
    $plans = Plan::withCount('subscriptions')->get(); // Count the number of subscriptions for each plan

    return view('superadmin.report.usage', compact('plans'));
}


public function userPurchasesReport()
{
    // Get the current logged-in superadmin's company ID
    $superadmin = Auth::user();
    $companyId = $superadmin->company_id;

    // Get the current month and year
    $currentMonth = \Carbon\Carbon::now()->month;
    $currentYear = \Carbon\Carbon::now()->year;

    // Fetch all user bookings along with related movie, showtime, and payment details
    $bookings = Booking::with(['user', 'showtime.movie', 'payment'])
        ->whereHas('user', function($query) use ($companyId) {
            $query->where('role_id', 1)  // Role 1 (user)
                  ->where('company_id', $companyId);  // Ensure the user belongs to the superadmin's company
        })
        ->orderBy('created_at', 'desc')
        ->get();

    // Calculate the total revenue for the current month specific to the superadmin's company
    $totalRevenue = Payment::whereHas('booking.user', function($query) use ($companyId) {
            $query->where('company_id', $companyId); // Filter by company_id
        })
        ->whereMonth('created_at', $currentMonth)
        ->whereYear('created_at', $currentYear)
        ->where('status', 'paid')
        ->sum('amount');

    // Subscription spending report (total spending by the logged-in superadmin)
    $subscriptionHistory = SuperadminPayment::where('superadmin_id', $superadmin->id)
        ->orderBy('paid_at', 'desc')
        ->with('plan')  // Eager load the 'plan' relationship to fetch the plan details with each payment
        ->get();

    // Calculate the total subscription spending
    $totalSubscriptionSpending = $subscriptionHistory->sum('amount');  // Total amount spent on subscriptions

    // Pass the data to the view
    return view('superadmin.report.user_purchases', compact('bookings', 'totalRevenue', 'totalSubscriptionSpending', 'subscriptionHistory'));
}


}
