@extends('layouts.app')

@section('title', 'Staff Dashboard')

@section('content')

<style>
.list-group-item {
    background: #1e1e1e;
}

strong{
    color: white;
}
</style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <!-- Dashboard Header -->
            <div class="text-center mb-4">
                <h1 class="fw-bold">Welcome to Your Dashboard</h1>
                <p class="text-muted">Here, you can manage your tasks, check your shifts, and monitor hall assignments.</p>
            </div>

            <!-- Assigned Tasks Section -->
            <div class="mb-5">
                <h4 class="fw-semibold">Assigned Tasks</h4>
                <p>Here you'll see your daily tasks and responsibilities.</p>
                <button class="btn btn-outline-primary w-100">View Tasks</button> {{-- Link to task management page later --}}
            </div>

            <!-- Hall Readiness Section -->
            <div class="mb-5">
                <h4 class="fw-semibold">Hall Readiness</h4>
                <p>Ensure that your assigned hall is ready for the next screening. Check if seating, equipment, and environment are set up properly.</p>
                <button class="btn btn-outline-secondary w-100">Check Hall Status</button> {{-- Link to hall management page --}}
            </div>

            <!-- Shift Management Section -->
            <div class="mb-5">
                <h4 class="fw-semibold">Shift Overview</h4>
                <p>Track your upcoming shifts and ensure you’re ready to take over your responsibilities.</p>
                <button class="btn btn-outline-success w-100">View Shifts</button> {{-- Link to shift management page --}}
            </div>

            <!-- Today's Showtimes Section -->
            <div class="mb-5">
                <h4 class="fw-semibold">Today's Showtimes</h4>
                <ul class="list-group">
                    @foreach($showtimes as $showtime)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong >{{ $showtime->movie->title }}</strong><br>
                                <span>Time: {{ \Carbon\Carbon::parse($showtime->start_time)->format('M d, H:i') }}</span>
                            </div>
                            <div class="d-flex flex-column justify-content-end">
                                <span class="badge bg-info text-dark">{{ $showtime->hall->name ?? 'N/A' }}</span><br>
                                <span class="badge bg-warning text-dark">{{ $showtime->is_3d ? '3D' : '2D' }}</span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Quick Notifications Section -->
            <div class="mb-5">
                <h4 class="fw-semibold">Recent Notifications</h4>
                <ul class="list-group">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Next 3D Movie Screening at 14:30</span>
                        <span class="badge bg-info text-dark">Upcoming</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Booking Status Update: Movie 'Inception'</span>
                        <span class="badge bg-warning text-dark">Pending</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>Emergency: Check Hall 2 Equipment</span>
                        <span class="badge bg-danger text-dark">Urgent</span>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>

@endsection
