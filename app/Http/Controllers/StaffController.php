<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


use App\Models\Showtime;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function index()
    {
        // Get the currently authenticated staff user
        $staff = Auth::user();

        // Fetch the company_id directly from the user (assumes company_id exists on users table)
        $companyId = $staff->company_id;
            $showtimes = Showtime::with('movie', 'hall')
                ->whereDate('start_time', Carbon::today())
                ->get();



        // Fetch tasks assigned to the logged-in staff, filtered by the company
        $assignedTasks = Assignment::where('staff_id', $staff->id)
                                   ->whereHas('task', function ($query) use ($companyId) {
                                       $query->where('company_id', $companyId);
                                   })
                                   ->with('task')
                                   ->get();

        return view('staff.dashboard', compact('assignedTasks' , 'showtimes'));
    }

// StaffController.php

public function completeTask($id)
{
    $task = Assignment::findOrFail($id);

    if ($task->staff_id !== Auth::id()) {
        return response()->json(['error' => 'Unauthorized action.'], 403);
    }

    $task->update(['is_completed' => true]);

    return response()->json(['success' => true, 'message' => 'Task marked as completed!']);
}






    public function profile()
    {
        $staff = Auth::user();
        return view('staff.profile', compact('staff'));
    }

public function assignedTasks()
{
    $user = auth()->user();

    // Fetch tasks assigned to the staff based on company_id and role_id
    // We only want tasks that belong to the same company as the logged-in user
    // and tasks that are assigned to the logged-in staff (staff_id).
    $tasks = Assignment::with('task')  // Eager load the task details
                        ->where('staff_id', $user->id)
                        ->whereHas('task', function ($query) use ($user) {
                            $query->where('company_id', $user->company_id);
                        })
                        ->get()
                        ->unique(function($task) {
                            return $task->task->task_name;  // Check uniqueness based on task title
                        });

    return view('staff.tasks.index', compact('tasks'));
}



public function todaysShowtimes()
{
    // Get today's date
    $today = Carbon::today();

    // Fetch showtimes for today
    $showtimes = Showtime::whereDate('start_time', $today)
        ->with('movie') // Assuming each showtime has a movie relation
        ->orderBy('start_time', 'asc')
        ->get();

    return view('staff.showtimes.today', compact('showtimes'));
}

}
