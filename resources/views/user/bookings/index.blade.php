@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header ">
            <h4 class="fw-bold mb-0">My Bookings</h4>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if($bookings->isEmpty())
                <div class="alert alert-info">You haven't booked any tickets yet.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Movie</th>
                                <th>Hall</th>
                                <th>Seats</th>
                                <th>Showtime</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                      <tbody>
    @foreach($bookings as $index => $booking)
        <tr class="clickable-row" data-href="{{ route('user.bookings.ticket') }}?booking_id={{ $booking->id }}">
            <td>{{ $index + 1 }}</td>
            <td>{{ $booking->showtime->movie->title ?? 'N/A' }}</td>
            <td>{{ $booking->showtime->hall->name ?? 'N/A' }}</td>
            <td>
                @php
                    $seatModels = \App\Models\Seat::whereIn('id', $booking->seats)->get();
                @endphp
                @foreach($seatModels as $seat)
                    <span class="badge bg-secondary">
                        Row {{ $seat->seat_row }}, Col {{ $seat->seat_column }}
                    </span>
                @endforeach
            </td>
       <td>{{ $booking->showtime ? \Carbon\Carbon::parse($booking->showtime->start_time)->format('Y-m-d H:i') : 'N/A' }}</td>

            <td>
                <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : 'warning' }}">
                    {{ ucfirst($booking->status) }}
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






@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const rows = document.querySelectorAll('.clickable-row');
        rows.forEach(row => {
            row.style.cursor = 'pointer';
            row.addEventListener('click', () => {
                const href = row.getAttribute('data-href');
                if (href) {
                    window.location.href = href;
                }
            });
        });
    });
</script>
@endsection
