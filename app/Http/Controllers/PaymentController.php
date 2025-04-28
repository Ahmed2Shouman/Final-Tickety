<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
class PaymentController extends Controller
{
       public function index()
         {
            // $payments = Payment::with(['user', 'booking']) // eager load relations
            //             ->orderByDesc('created_at')
            //             ->get();
            $payments = Payment::with('booking.user')->latest()->get();


            return view('payments.index', compact('payments'));
         }

}
