@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="fw-bold mb-0">Create New Hall</h4>
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

            <form action="{{ route('halls.store') }}" method="POST">
                @csrf

                <!-- Cinema Dropdown -->
                <div class="mb-3">
                    <label for="cinema_id" class="form-label">Cinema</label>
                    <select name="cinema_id" id="cinema_id" class="form-select" required>
                        <option value="">-- Select Cinema --</option>
                        @foreach ($cinemas as $cinema)
                            <option value="{{ $cinema->id }}">{{ $cinema->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Hall Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Hall Name</label>
                    <input type="text" name="name" id="name" class="form-control" required placeholder="e.g. Hall A">
                </div>

                <!-- Seat Rows -->
                <div class="mb-3">
                    <label for="seat_row_count" class="form-label">Number of Rows</label>
                    <input type="number" name="seat_row_count" id="seat_row_count" class="form-control" required min="1">
                </div>

                <!-- Seat Columns -->
                <div class="mb-3">
                    <label for="seat_column_count" class="form-label">Number of Columns</label>
                    <input type="number" name="seat_column_count" id="seat_column_count" class="form-control" required min="1">
                </div>
            <!-- VIP Seats -->
            <div class="mb-3">
                <label for="number_of_vip_seats" class="form-label">Number of VIP Seats</label>
                <input type="number" name="number_of_vip_seats" id="number_of_vip_seats" class="form-control" required min="0">
            </div>

            <!-- Standard Seats -->
            <div class="mb-3">
                <label for="number_of_standard_seats" class="form-label">Number of Standard Seats</label>
                <input type="number" name="number_of_standard_seats" id="number_of_standard_seats" class="form-control" required min="0">
            </div>

                <div class="d-grid">
                    <button type="submit" class="btn">Create Hall</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
