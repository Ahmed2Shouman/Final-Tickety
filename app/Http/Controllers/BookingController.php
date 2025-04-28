<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Showtime;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    

   public function index()
    {
        $bookings = Booking::with(['user', 'seat', 'showtime.movie', 'showtime.hall'])->latest()->get();
        return view('bookings.index', compact('bookings'));
    }

}
