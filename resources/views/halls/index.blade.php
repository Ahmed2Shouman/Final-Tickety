@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header  d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">All Halls</h4>
            <a href="{{ route('halls.create') }}" class="btn btn-primary btn-sm">+ Add New Hall</a>
        </div>

        <div class="card-body">
            @if($halls->isEmpty())
                <div class="alert alert-info">No halls found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Hall Name</th>
                                <th>Cinema</th>
                                <th>Capacity</th>
                                <th>Total Seats</th>
                                <th>Total Showtimes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($halls as $index => $hall)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $hall->name }}</td>
                                    <td>{{ $hall->cinema->name ?? 'N/A' }}</td>
                                    <td>{{ $hall->seat_row_count * $hall->seat_column_count }}</td>
                                    <td>{{ $hall->seats->whereIn('seat_type', ['vip', 'standard'])->count() }}</td>
                                    <td>{{ $hall->showtimes->count() }}</td>
                                    <td>
                                        <a href="{{ route('halls.edit', $hall->id) }}" class="btn btn-sm ">Edit</a>
                                        <a href="{{ route('halls.view_seats', $hall->id) }}" class="btn btn-sm">View Seats</a>
                                        <form action="{{ route('halls.destroy', $hall->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this hall?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm ">Delete</button>
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
