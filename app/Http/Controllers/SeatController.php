<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seat;
class SeatController extends Controller
{
   public function updateBulk(Request $request, $hallId)
{
    $seatUpdates = $request->input('seats', []);

    foreach ($seatUpdates as $seatId => $type) {
        Seat::where('id', $seatId)->update([
            'seat_type' => $type
        ]);
    }

    return redirect('halls')->with('success', 'Seat types updated successfully.');
}

}
