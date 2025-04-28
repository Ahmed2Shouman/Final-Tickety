<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Hall;
use App\Models\Movie;


class ShowtimeController extends Controller
{
public function index()
{
    $companyId = auth()->user()->company_id;  // Get the logged-in user's company_id

    $showtimes = Showtime::with(['movie', 'hall.cinema'])
        ->whereHas('hall.cinema', function ($query) use ($companyId) {
            $query->where('company_id', $companyId); // Filter showtimes by the user's company_id
        })
        ->latest()
        ->get();

    return view('showtimes.index', compact('showtimes'));
}




public function create()
{
    $companyId = auth()->user()->company_id;  // Get the logged-in user's company_id

    $movies = \App\Models\Movie::all();
    $halls = \App\Models\Hall::with('cinema')
        ->whereHas('cinema', function ($query) use ($companyId) {
            $query->where('company_id', $companyId); // Filter halls by the user's company_id
        })
        ->get();

    return view('showtimes.create', compact('movies', 'halls'));
}

public function store(Request $request)
{
    $request->validate([
        'movie_id'    => 'required|exists:movies,id',
        'hall_id'     => 'required|exists:halls,id',
        'start_time'  => 'required|date',
        'end_time'    => 'required|date|after:start_time',
        'language'    => 'required|string|max:50',
        'is_3d'       => 'nullable|boolean',
        'ticket_price'=> 'required|numeric|min:0',   // new
    ]);


    $hall = Hall::findOrFail($request->hall_id);
    $cinema = $hall->cinema; // Get the cinema associated with the hall

    // Check if the cinema belongs to the same company as the logged-in user
    if ($cinema->company_id != auth()->user()->company_id) {
        return back()->withErrors(['cinema' => 'This hall does not belong to your company.'])->withInput();
    }

  

    // Create Showtime
    Showtime::create([
        'movie_id'     => $request->movie_id,
        'hall_id'      => $request->hall_id,
        'start_time'   => $request->start_time,
        'end_time'     => $request->end_time,
        'language'     => $request->language,
        'is_3d'        => $request->has('is_3d'),
        'ticket_price' => $request->ticket_price,  // new
        'cinema_id'    => $cinema->id,  // Set the cinema_id for the showtime (get it from the hall's cinema)
    ]);

    return redirect()->route('showtimes.index')->with('success', 'Showtime created successfully.');
}



public function edit($id)
{
    $companyId = auth()->user()->company_id;  // Get the logged-in user's company_id

    $showtime = Showtime::findOrFail($id);
    $movies = Movie::all();
    $halls = Hall::with('cinema')
        ->whereHas('cinema', function ($query) use ($companyId) {
            $query->where('company_id', $companyId); // Filter halls by the user's company_id
        })
        ->get();

    // Ensure that the showtime belongs to a hall that belongs to the user's company
    if ($showtime->hall->cinema->company_id != $companyId) {
        return redirect()->route('showtimes.index')->with('error', 'You do not have permission to edit this showtime.');
    }

    return view('showtimes.edit', compact('showtime', 'movies', 'halls'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'movie_id'    => 'required|exists:movies,id',
        'hall_id'     => 'required|exists:halls,id',
        'start_time'  => 'required|date',
        'end_time'    => 'required|date|after:start_time',
        'language'    => 'required|string|max:50',
        'is_3d'       => 'nullable|boolean',
        'ticket_price'=> 'required|numeric|min:0',   // new
    ]);

    $showtime = Showtime::findOrFail($id);

    // Ensure that the hall associated with the showtime belongs to the same company as the logged-in user
    $hall = Hall::findOrFail($request->hall_id);
    if ($hall->cinema->company_id != auth()->user()->company_id) {
        return back()->withErrors(['cinema' => 'This hall does not belong to your company.'])->withInput();
    }

    $showtime->update([
        'movie_id'     => $request->movie_id,
        'hall_id'      => $request->hall_id,
        'start_time'   => $request->start_time,
        'end_time'     => $request->end_time,
        'language'     => $request->language,
        'is_3d'        => $request->has('is_3d'),
        'ticket_price' => $request->ticket_price,  // new
    ]);

    return redirect()->route('showtimes.index')->with('success', 'Showtime updated successfully.');
}
public function destroy($id)
{
    $showtime = Showtime::findOrFail($id);

    // Ensure the showtime belongs to a hall that is associated with the user's company
    if ($showtime->hall->cinema->company_id != auth()->user()->company_id) {
        return redirect()->route('showtimes.index')->with('error', 'You do not have permission to delete this showtime.');
    }

    // Delete the related bookings first (if any)
    $showtime->bookings()->delete();

    // Delete the showtime
    $showtime->delete();

    return redirect()->route('showtimes.index')->with('success', 'Showtime and its bookings are deleted successfully.');
}


}
