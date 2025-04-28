<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hall;
use App\Models\Cinema;
use App\Models\Seat;

class HallController extends Controller
{
  
public function index()
{
    $companyId = auth()->user()->company_id;  // Get the logged-in user's company_id

    // Fetch halls that belong to cinemas in the same company
    $halls = Hall::with(['cinema', 'seats', 'showtimes'])
                 ->whereHas('cinema', function ($query) use ($companyId) {
                     $query->where('company_id', $companyId); // Filter cinemas by company_id
                 })
                 ->latest()
                 ->get();

    return view('halls.index', compact('halls'));
}


public function create()
{
    $companyId = auth()->user()->company_id;  // Get the logged-in user's company_id

    // Fetch cinemas that belong to the same company
    $cinemas = Cinema::where('company_id', $companyId)->get();

    return view('halls.create', compact('cinemas'));
}

 public function store(Request $request)
{
    $request->validate([
        'cinema_id' => 'required|exists:cinemas,id',
        'name' => 'required|string|max:255',
        'seat_row_count' => 'required|integer|min:1',
        'seat_column_count' => 'required|integer|min:1',
        'number_of_vip_seats' => 'required|integer|min:0',
        'number_of_standard_seats' => 'required|integer|min:0',
    ]);

    // Ensure the selected cinema belongs to the current user's company
    $cinema = Cinema::findOrFail($request->cinema_id);
    if ($cinema->company_id != auth()->user()->company_id) {
        return back()->withErrors(['cinema' => 'This cinema does not belong to your company.']);
    }

    // Create hall
    $hall = Hall::create([
        'cinema_id' => $request->cinema_id,
        'name' => $request->name,
        'seat_row_count' => $request->seat_row_count,
        'seat_column_count' => $request->seat_column_count,
    ]);

    $vipCount = $request->number_of_vip_seats;
    $standardCount = $request->number_of_standard_seats;

    // Generate seats
    for ($row = 1; $row <= $request->seat_row_count; $row++) {
        for ($col = 1; $col <= $request->seat_column_count; $col++) {
            if ($vipCount-- > 0) {
                $type = 'vip';
                $price = 15.00;
            } elseif ($standardCount-- > 0) {
                $type = 'standard';
                $price = 12.00;
            } else {
                $type = 'not_assigned';
                $price = 0.00;
            }

            Seat::create([
                'hall_id' => $hall->id,
                'seat_row' => $row,
                'seat_column' => $col,
                'seat_type' => $type,
                'is_available' => true,
                'seat_price' => $price,
            ]);
        }
    }

    return redirect()->route('halls.index')->with('success', 'Hall and seats created successfully.');
}


        public function destroy($id)
            {
                $hall = Hall::findOrFail($id);

                // Delete all related seats
                $hall->seats()->delete();

                // Delete the hall
                $hall->delete();

                return redirect()->route('halls.index')->with('success', 'Hall and its seats deleted successfully.');
            }
            
        public function viewSeats($hallId)
            {
                $hall = Hall::with('seats')->findOrFail($hallId);
                return view('halls.view_seats', compact('hall'));
            }
            
  

public function edit($id)
{
    $companyId = auth()->user()->company_id;  // Get the logged-in user's company_id

    // Retrieve the hall along with its associated seats, and ensure it belongs to a cinema in the same company
    $hall = Hall::with('seats')->findOrFail($id);
    
    // Check if the hall's cinema belongs to the same company
    if ($hall->cinema->company_id !== $companyId) {
        return redirect()->route('halls.index')->with('error', 'You do not have access to this hall.');
    }

    $vipSeatsCount = $hall->seats->where('seat_type', 'vip')->count();
    $standardSeatsCount = $hall->seats->where('seat_type', 'standard')->count();
    
    $cinemas = Cinema::where('company_id', $companyId)->get();  // Fetch cinemas for the current company

    return view('halls.edit', compact('hall', 'cinemas', 'vipSeatsCount', 'standardSeatsCount'));
}






public function update(Request $request, $id)
{
    $request->validate([
        'cinema_id' => 'required|exists:cinemas,id',
        'name' => 'required|string|max:255',
        'seat_row_count' => 'required|integer|min:1',
        'seat_column_count' => 'required|integer|min:1',
        'number_of_vip_seats' => 'required|integer|min:0',
        'number_of_standard_seats' => 'required|integer|min:0',
    ]);

    $hall = Hall::findOrFail($id);
    $companyId = auth()->user()->company_id;

    // Ensure that the hall's cinema belongs to the same company
    if ($hall->cinema->company_id != $companyId) {
        return redirect()->route('halls.index')->with('error', 'You do not have permission to update this hall.');
    }

    $layoutChanged = $hall->seat_row_count != $request->seat_row_count || $hall->seat_column_count != $request->seat_column_count;

    // 1) Update hall metadata
    $hall->update([
        'cinema_id' => $request->cinema_id,
        'name' => $request->name,
        'seat_row_count' => $request->seat_row_count,
        'seat_column_count' => $request->seat_column_count,
    ]);

    // 2) Rebuild seats if layout or counts changed
    if ($layoutChanged || $request->number_of_vip_seats != $hall->seats->where('seat_type', 'vip')->count() || $request->number_of_standard_seats != $hall->seats->where('seat_type', 'standard')->count()) {
        $hall->seats()->delete();

        $vipCount = $request->number_of_vip_seats;
        $standardCount = $request->number_of_standard_seats;

        for ($row = 1; $row <= $hall->seat_row_count; $row++) {
            for ($col = 1; $col <= $hall->seat_column_count; $col++) {
                if ($vipCount-- > 0) {
                    $type = 'vip';
                    $price = 15.00;
                } elseif ($standardCount-- > 0) {
                    $type = 'standard';
                    $price = 12.00;
                } else {
                    $type = 'not_assigned';
                    $price = 0.00;
                }

                Seat::create([
                    'hall_id' => $hall->id,
                    'seat_row' => $row,
                    'seat_column' => $col,
                    'seat_type' => $type,
                    'is_available' => true,
                    'seat_price' => $price,
                ]);
            }
        }

        return redirect()->route('halls.index')->with('warning', 'Seats were regenerated with updated prices.');
    }

    return redirect()->route('halls.index')->with('success', 'Hall updated successfully.');
}





}
