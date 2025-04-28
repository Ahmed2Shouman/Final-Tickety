@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header  d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">All Showtimes</h4>
            <a href="{{ route('showtimes.create') }}" class="btn btn-primary btn-sm">+ Add New Showtime</a>
        </div>

        <div class="card-body">

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($showtimes->isEmpty())
                <div class="alert alert-info">No showtimes found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Movie</th>
                                <th>Cinema</th>
                                <th>Hall</th>
                                <th>Language</th>
                                <th>3D</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($showtimes as $index => $showtime)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ optional($showtime->movie)->title ?? 'N/A' }}</td>
                                  <td>{{ optional(optional($showtime->hall)->cinema)->name ?? 'N/A' }}</td>

                                    <td>{{ optional($showtime->hall)->name ?? 'N/A' }}</td>
                                    <td>{{ $showtime->language ?? 'N/A' }}</td>
                                  <td>
                                    {{ $showtime->is_3d === 1 ? 'Yes' : ($showtime->is_3d === 0 ? 'No' : 'N/A') }}
                                </td>

                                    <td>{{ \Carbon\Carbon::parse($showtime->start_time)->format('Y-m-d H:i') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($showtime->end_time)->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <a href="{{ route('showtimes.edit', $showtime->id) }}" class="btn btn-sm">Edit</a>

                                        <form action="{{ route('showtimes.destroy', $showtime->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this showtime?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm">Delete</button>
                                        </form>
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
