@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header ">
            <h4 class="fw-bold mb-0">Edit Showtime</h4>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('showtimes.update', $showtime->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Movie -->
                <div class="mb-3">
                    <label for="movie_id" class="form-label">Movie</label>
                    <select name="movie_id" id="movie_id" class="form-select" required>
                        @foreach ($movies as $movie)
                            <option value="{{ $movie->id }}" {{ $showtime->movie_id == $movie->id ? 'selected' : '' }}>
                                {{ $movie->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Hall -->
                <div class="mb-3">
                    <label for="hall_id" class="form-label">Hall</label>
                    <select name="hall_id" id="hall_id" class="form-select" required>
                        @foreach ($halls as $hall)
                            <option value="{{ $hall->id }}" {{ $showtime->hall_id == $hall->id ? 'selected' : '' }}>
                                {{ $hall->name }} ({{ $hall->cinema->name ?? 'N/A' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Ticket Price -->
<div class="mb-3">
  <label for="ticket_price" class="form-label">Ticket Price</label>
  <input
    type="number"
    name="ticket_price"
    id="ticket_price"
    class="form-control"
    step="0.01"
    min="0"
    value="{{ old('ticket_price', $showtime->ticket_price) }}"
    required
  >
</div>

                <!-- Start Time -->
                <div class="mb-3">
                    <label for="start_time" class="form-label">Start Time</label>
                    <input type="datetime-local" name="start_time" id="start_time" class="form-control"
                           value="{{ \Carbon\Carbon::parse($showtime->start_time)->format('Y-m-d\TH:i') }}" required>
                </div>

                <!-- End Time -->
                <div class="mb-3">
                    <label for="end_time" class="form-label">End Time</label>
                    <input type="datetime-local" name="end_time" id="end_time" class="form-control"
                           value="{{ \Carbon\Carbon::parse($showtime->end_time)->format('Y-m-d\TH:i') }}" required>
                </div>

                <!-- Language -->
                <div class="mb-3">
                    <label for="language" class="form-label">Language (optional)</label>
                    <input type="text" name="language" id="language" class="form-control"
                           value="{{ old('language', $showtime->language) }}">
                </div>

                <!-- Is 3D -->
                <div class="form-check mb-3">
                    <input type="checkbox" name="is_3d" id="is_3d" value="1" class="form-check-input"
                           {{ $showtime->is_3d ? 'checked' : '' }}>
                    <label for="is_3d" class="form-check-label">3D Showtime</label>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Update Showtime</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
