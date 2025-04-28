@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header  d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">Seats for {{ $hall->name }}</h4>
            <form method="POST" action="{{ route('seats.update_bulk', $hall->id) }}">
                @csrf
                @method('PUT')
                <button type="submit" class="btn btn-success btn-sm">Save Changes</button>
        </div>
        <div class="card-body">
            @if($hall->seats->isEmpty())
                <div class="alert alert-info">No seats found for this hall.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Row</th>
                                <th>Column</th>
                                <th>Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hall->seats as $index => $seat)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $seat->seat_row }}</td>
                                    <td>{{ $seat->seat_column }}</td>
                                    <td>
                                        <select name="seats[{{ $seat->id }}]" class="form-select form-select-sm">
                                            <option value="standard" {{ $seat->seat_type === 'standard' ? 'selected' : '' }}>Standard</option>
                                            <option value="vip" {{ $seat->seat_type === 'vip' ? 'selected' : '' }}>VIP</option>
                                            <option value="not_assigned" {{ $seat->seat_type === 'not_assigned' ? 'selected' : '' }}>Not Assigned</option>
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
        </form>
    </div>
</div>
@endsection
