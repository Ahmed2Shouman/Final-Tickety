@extends('layouts.app')

@section('title', 'View Assignments for ' . $staff->name)

@section('content')

<style>
td , .badge{
    color : white !important;
}



</style>

<div class="container mt-5">
    <div class="card shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Assignments for {{ $staff->name }}</h4>
            <a href="{{ route('admin.manage_staff.viewStaff') }}" class="btn">Back to Staff</a>
        </div>
        <div class="card-body">
            @if ($assignments->isEmpty())
                <div class="alert alert-warning" role="alert">
                    No assignments found for this staff member.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Task</th>
                                <th>Assigned On</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assignments as $assignment)
                                <tr>
                                    <td>{{ $assignment->task->task_name }}</td>
                                    <td>{{ $assignment->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        <span class="badge {{ $assignment->is_completed ? 'bg-success' : 'bg-warning' }}">
                                            {{ $assignment->is_completed ? 'Completed' : 'Pending' }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

