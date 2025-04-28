<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }

    public function bookingIndex()
    {
        $user = auth()->user();

        $bookings = Booking::with(['showtime.movie', 'showtime.hall', 'seat'])
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        return view('user.bookings.index', compact('bookings'));
    }

    public function moviesIndex()
    {
        $movies = Movie::latest()->get();
        return view('user.movies.index', compact('movies'));
    }









        public function showMovie($id)
            {
                // Retrieve the movie with its showtimes and each hall’s seats,
                // but only seats that aren’t 'not_assigned'
                $movie = Movie::with([
                    'showtimes.hall.seats' => function($q) {
                        $q->where('seat_type', '!=', 'not_assigned');
                    }
                ])->findOrFail($id);

                return view('user.movies.show', compact('movie'));
            }

        
public function pay(Request $request)
{
    // Validate that we got exactly what we need
    $request->validate([
        'movie_id'    => 'required|exists:movies,id',
        'showtime_id' => 'required|exists:showtimes,id',
        'seats'       => 'required|json',
    ]);

    // Load the movie & showtime
    $movie    = Movie::findOrFail($request->movie_id);
    $showtime = Showtime::findOrFail($request->showtime_id);

    // Decode the JSON array of seat IDs
    $seatIds = json_decode($request->seats, true);

    // Load those Seat models
    $seats = Seat::whereIn('id', $seatIds)->get();

    // Pass them all to the view, plus the per‐ticket price
    return view('user.bookings.pay', [
        'movie'            => $movie,
        'showtime'         => $showtime,
        'seats'            => $seats,
        'price_per_ticket' => $showtime->ticket_price,
        'total' => $request->total_price, // 👈 Pass it directly from the request
    ]);
}









public function Stripe(Request $request)
{
    $request->validate([
        'movie_id'    => 'required|exists:movies,id',
        'showtime_id' => 'required|exists:showtimes,id',
        'seats'       => 'required|json',
        'stripeToken' => 'required',
        'price'       => 'required|numeric',
    ]);

    // Check if the user has already booked this movie and showtime
    $existingBooking = Booking::where('user_id', auth()->id())
        ->where('showtime_id', $request->showtime_id)
        ->exists();

    if ($existingBooking) {
        // Inform the user that they have already booked this movie
        return back()->withErrors(['movie' => 'You have already booked this movie and showtime.'])->withInput();
    }

    $seatIds = json_decode($request->seats, true);

    // Check if any of the selected seats are already booked
    foreach ($seatIds as $seatId) {
        $alreadyBooked = Booking::where('showtime_id', $request->showtime_id)
            ->whereJsonContains('seats', $seatId)
            ->exists();

        if ($alreadyBooked) {
            return back()->withErrors(['seats' => "Seat ID $seatId is already booked."])->withInput();
        }
    }

    // Create one booking that stores all selected seat IDs
    $booking = Booking::create([
        'user_id'     => auth()->id(),
        'showtime_id' => $request->showtime_id,
        'seats'       => $seatIds, // stored as JSON
        'status'      => 'confirmed',
    ]);

    // Create Stripe customer & charge
    $stripe = new \Stripe\StripeClient(env('USER_STRIPE_SECRET'));

    // Create Stripe customer
    $customer = $stripe->customers->create([
        'name'  => auth()->user()->name,
        'email' => auth()->user()->email,
        'source' => $request->stripeToken,
    ]);

    // Charge the customer
    $charge = $stripe->charges->create([
        'amount'      => $request->price * 100, // Convert dollars to cents
        'currency'    => 'usd',
        'customer'    => $customer->id,
        'description' => "Payment for booking tickets",
    ]);

    // Create the payment record
    Payment::create([
        'booking_id'         => $booking->id,
        'user_id'            => auth()->id(),
        'amount'             => $request->price,
        'method'             => 'card',
        'status'             => $charge->status === 'succeeded' ? 'paid' : 'failed',
        'currency'           => $charge->currency,
        'card_brand'         => $charge->payment_method_details['card']['brand'] ?? null,
        'card_last4'         => $charge->payment_method_details['card']['last4'] ?? null,
        'transaction_id'     => $charge->id,
        'stripe_receipt_url' => $charge->receipt_url,
        'paid_at'            => now(),
    ]);

    return redirect()->route('user.bookings.ticket', [
        'booking_id' => $booking->id,
    ]);
}









        public function Ticket(Request $request)
        {
            $booking = Booking::with('showtime', 'payment')->findOrFail($request->booking_id);
            $movie = Movie::findOrFail($booking->showtime->movie_id);
            $payment = $booking->payment;

            return view('user.bookings.ticket', compact('booking', 'movie', 'payment'));
        }



    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    
public function updateProfile(Request $request, $id)
{
    // Validate the incoming request
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id, // Ensures the email is unique except for the current user
        'phone' => 'required|string|max:20',
        'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Optionally handle image upload
    ]);

    // Find the Super user by ID
    $user = User::findOrFail($id);

    // Update the Super user's profile
    $user->name = $request->name;
    $user->email = $request->email;
    $user->phone = $request->phone;

    // Handle profile image upload (if any)
    if ($request->hasFile('profile_image')) {
        // Delete the old profile image if it exists
        if ($user->profile_image) {
            $oldImagePath = public_path('storage/' . $user->profile_image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image
            }
        }

        // Store the new image
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        // Update the profile image path in the database
        $user->profile_image = $imagePath;
    }

    // Save the updated data
    $user->save();

    // Redirect back to the profile page with a success message
    return redirect()->route('user.profile')->with('success', 'Profile updated successfully!');
}





}



// Visa	4242424242424242

// Visa (debit)	4000056655665556

// Mastercard	5555555555554444

// Mastercard (2-series)	2223003122003222

// Mastercard (debit)	5200828282828210

// Mastercard (prepaid)	5105105105105100

// American Express	371449635398431

// Discover	6011000990139424