<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
 public function index()
    {
        // Get the company_id of the logged-in user
        $companyId = auth()->user()->company_id;

        // Fetch movies for the logged-in user's company
        $movies = Movie::where('company_id', $companyId)->with('showtimes')->latest()->get();

        return view('movies.index', compact('movies'));
    }




    public function create()
    {
        return view('movies.create');
    }

     public function store(Request $request)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_hours'   => 'nullable|integer|min:0',
            'duration_mins'    => 'nullable|integer|min:0|max:59',
            'genre'            => 'nullable|string|max:50',
            'rating'           => 'nullable|string|max:10',
            'poster_url'       => 'nullable|url',
            'trailer_url'      => 'nullable|url',
        ]);

        // Calculate the duration in minutes
        $duration_minutes = ($request->duration_hours * 60) + $request->duration_mins;

        // Get the company_id of the logged-in user
        $companyId = auth()->user()->company_id;

        // Create the movie and associate it with the company_id
        Movie::create([
            'title'            => $request->title,
            'description'      => $request->description,
            'duration_minutes' => $duration_minutes,
            'genre'            => $request->genre,
            'rating'           => $request->rating,
            'poster_url'       => $request->poster_url,
            'trailer_url'      => $request->trailer_url,
            'company_id'       => $companyId,  // Assign company_id
        ]);

        return redirect()->route('movies.index')->with('success', 'Movie created successfully.');
    }

    public function show($id)
    {
        // Get the company_id of the logged-in user
        $companyId = auth()->user()->company_id;

        // Fetch the movie and ensure it belongs to the logged-in user's company
        $movie = Movie::where('company_id', $companyId)->findOrFail($id);
        
        return response()->json($movie);
    }

  public function edit($id)
    {
        // Get the company_id of the logged-in user
        $companyId = auth()->user()->company_id;

        // Fetch the movie and ensure it belongs to the logged-in user's company
        $movie = Movie::where('company_id', $companyId)->findOrFail($id);

        return view('movies.edit', compact('movie'));
    }

   
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'duration_hours'   => 'nullable|integer|min:0',
            'duration_mins'    => 'nullable|integer|min:0|max:59',
            'genre'            => 'required|string|max:50',
            'rating'           => 'required|integer|min:1|max:5',
            'poster_url'       => 'nullable|url',
            'trailer_url'      => 'nullable|url',
        ]);

        // Get the company_id of the logged-in user
        $companyId = auth()->user()->company_id;

        // Fetch the movie and ensure it belongs to the logged-in user's company
        $movie = Movie::where('company_id', $companyId)->findOrFail($id);

        $movie->update([
            'title'            => $request->title,
            'description'      => $request->description,
            'duration_minutes' => ($request->duration_hours * 60) + $request->duration_mins,
            'genre'            => $request->genre,
            'rating'           => $request->rating,
            'poster_url'       => $request->poster_url,
            'trailer_url'      => $request->trailer_url,
        ]);

        return redirect()->route('movies.index')->with('success', 'Movie updated successfully.');
    }
   
  public function destroy($id)
    {
        // Get the company_id of the logged-in user
        $companyId = auth()->user()->company_id;

        // Fetch the movie and ensure it belongs to the logged-in user's company
        $movie = Movie::where('company_id', $companyId)->findOrFail($id);

        // Delete related showtimes first
        $movie->showtimes()->delete();

        // Delete the movie
        $movie->delete();

        return redirect()->route('movies.index')->with('success', 'Movie and its showtimes were deleted successfully.');
    }

     

              
}
