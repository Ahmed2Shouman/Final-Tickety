<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CinemaController extends Controller
{


   public function index()
    {
        // Get the company ID of the logged-in user
        $companyId = Auth::user()->company_id;

        // Fetch cinemas belonging to the logged-in user's company
        $cinemas = Cinema::where('company_id', $companyId)
                        ->latest()
                        ->get();

        // Pass cinemas to the view
        return view('cinemas.index', compact('cinemas'));
    }


        public function create()
        {
            // Get the currently authenticated super admin
            $superAdmin = Auth::user(); 

            // Assuming the super admin has a company associated with them, get the company ID
            $company = $superAdmin->company; // Adjust based on your relationships, e.g., $superAdmin->company_id if it's not a relationship

            return view('cinemas.create', compact('company'));
        }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
       
        ]);

        Cinema::create($request->all());

        return redirect()->route('cinemas.index')->with('success', 'Cinema created successfully.');
    }

    public function edit($id)
    {
        $cinema = Cinema::findOrFail($id);
        $companies = Company::all();
        return view('cinemas.edit', compact('cinema', 'companies'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
           
        ]);

        $cinema = Cinema::findOrFail($id);
        $cinema->update($request->all());

        return redirect()->route('cinemas.index')->with('success', 'Cinema updated successfully.');
    }

    public function destroy($id)
    {
        $cinema = Cinema::findOrFail($id);
        $cinema->delete();

        return redirect()->route('cinemas.index')->with('success', 'Cinema deleted successfully.');
    }
}
