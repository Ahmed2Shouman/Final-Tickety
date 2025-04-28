<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Task;
use App\Models\Assignment;


class AdminController extends Controller
{
    // Admin Dashboard
    public function index()
    {
        return view('admin.dashboard');
    }

    // Show all staff members
 public function viewStaff()
{
    $companyId = auth()->user()->company_id; // Get company ID of the logged-in user
    $staffMembers = User::where('role_id', 4)->where('company_id', $companyId)->get(); // Fetch staff only for the same company
    return view('admin.manage_staff.viewStaff', compact('staffMembers')); // Pass staff data to the view
}


public function assignTaskForm()
{
    $companyId = auth()->user()->company_id; // Get company ID of the logged-in user
    $tasks = Task::where('company_id', $companyId)->get(); // Fetch tasks only for the current company
    return view('admin.manage_staff.assignTask', compact('tasks'));
}


public function assignTask(Request $request)
{
    $request->validate([
        'staff_id' => 'required|exists:users,id',
        'task_id' => 'required|exists:tasks,id',
    ]);

    // Get the company_id of the logged-in user
    $companyId = auth()->user()->company_id;

    // Fetch the staff member
    $staff = User::findOrFail($request->staff_id);

    // Ensure the staff member belongs to the same company as the logged-in user
    if ($staff->company_id != $companyId) {
        return redirect()->route('admin.manage_staff.viewStaff')->with('error', 'This staff member does not belong to your company.');
    }

    // Create the assignment if staff member belongs to the same company
    Assignment::create([
        'staff_id'     => $request->staff_id,
        'task_id'      => $request->task_id,
        'is_completed' => false,
    ]);

    return redirect()->route('admin.manage_staff.viewStaff')->with('success', 'Task assigned successfully!');
}

public function viewAssignments($staff_id)
{
    // Get the company_id of the logged-in user
    $companyId = auth()->user()->company_id;

    // Fetch the staff member
    $staff = User::findOrFail($staff_id);

    // Ensure the staff member belongs to the same company as the logged-in user
    if ($staff->company_id != $companyId) {
        return redirect()->route('admin.manage_staff.viewStaff')->with('error', 'You do not have access to this staff member.');
    }

    // Fetch assignments for the staff member
    $assignments = Assignment::where('staff_id', $staff_id)->get();

    return view('admin.manage_staff.viewAssignments', compact('staff', 'assignments'));
}




public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email',
        'phone' => 'required|string|max:20|unique:users,phone|regex:/^01[0-9]{9}$/', // Validate phone starts with 01 and is 11 digits
    ]);

    // Get the company ID of the logged-in user
    $companyId = auth()->user()->company_id;

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make('74108520'), // Default password
        'role_id' => 4, // Staff role
        'company_id' => $companyId, // Set company_id to the current company
    ]);

    return redirect()->route('admin.manage_staff.viewStaff')->with('success', 'Staff created successfully!');
}

    // Show Edit Staff Form
    public function edit($id)
    {
        $staff = User::findOrFail($id);
        return view('admin.manage_staff.edit', compact('staff'));
    }
public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,' . $id,
        'phone' => 'required|string|max:20|unique:users,phone,' . $id,
    ]);

    $staff = User::findOrFail($id);
    $companyId = auth()->user()->company_id;

    // Ensure that the staff belongs to the same company as the logged-in admin
    if ($staff->company_id != $companyId) {
        return redirect()->route('admin.manage_staff.viewStaff')->with('error', 'You do not have permission to edit this staff member.');
    }

    $staff->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    return redirect()->route('admin.manage_staff.viewStaff')->with('success', 'Staff updated successfully!');
}


public function delete($id)
{
    $staff = User::findOrFail($id);
    $companyId = auth()->user()->company_id;

    // Ensure that the staff belongs to the same company as the logged-in admin
    if ($staff->company_id != $companyId) {
        return redirect()->route('admin.manage_staff.viewStaff')->with('error', 'You do not have permission to delete this staff member.');
    }

    $staff->delete();

    return redirect()->route('admin.manage_staff.viewStaff')->with('success', 'Staff deleted successfully!');
}


    // Show Admin Profile
    public function profile()
    {
        $admin = Auth::user(); // Get the currently authenticated admin
        return view('admin.profile', compact('admin')); // Pass admin data to the profile view
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
    $admin = User::findOrFail($id);

    // Update the Super Admin's profile
    $admin->name = $request->name;
    $admin->email = $request->email;
    $admin->phone = $request->phone;

    // Handle profile image upload (if any)
    if ($request->hasFile('profile_image')) {
        // Delete the old profile image if it exists
        if ($admin->profile_image) {
            $oldImagePath = public_path('storage/' . $admin->profile_image);
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath); // Delete the old image
            }
        }

        // Store the new image
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        // Update the profile image path in the database
        $admin->profile_image = $imagePath;
    }

    // Save the updated data
    $admin->save();

    // Redirect back to the profile page with a success message
    return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
}



}
