@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header  d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">All Bookings</h4>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($bookings->isEmpty())
                <div class="alert alert-info">No bookings found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Seat</th>
                                <th>Hall</th>
                                <th>Movie</th>
                                <th>Status</th>
                                <th>Showtime</th>
                                <th>Booked At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $booking->user->name ?? 'N/A' }}</td>
                                    <td>Row {{ $booking->seat->seat_row ?? '?' }} - Col {{ $booking->seat->seat_column ?? '?' }}</td>
                                    <td>{{ $booking->showtime->hall->name ?? 'N/A' }}</td>
                                    <td>{{ $booking->showtime->movie->title ?? 'N/A' }}</td>
                                    <td>
                                        <span class="badge bg-{{ 
                                            $booking->status === 'confirmed' ? 'success' :
                                            ($booking->status === 'pending' ? 'warning' : 'danger')
                                        }}">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </td>
                                     <td>
                                        {{ $booking->showtime && $booking->showtime->start_time 
                                            ? \Carbon\Carbon::parse($booking->showtime->start_time)->format('Y-m-d H:i') 
                                            : 'N/A' }}
                                    </td>

                                    <td>
                                        {{ $booking->created_at 
                                            ? $booking->created_at->format('Y-m-d H:i') 
                                            : 'N/A' }}
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
