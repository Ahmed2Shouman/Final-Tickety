@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">All Cinemas</h4>
            <a href="{{ route('cinemas.create') }}" class="btn btn-outline">+ Add New Cinema</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($cinemas->isEmpty())
                <div class="alert alert-info">No cinemas found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark text-center">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Location</th>
                         
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cinemas as $index => $cinema)
                                <tr class="text-center">
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $cinema->name }}</td>
                                    <td>{{ $cinema->location }}</td>
                               
                                    <td>
                                        <a href="{{ route('cinemas.edit', $cinema->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('cinemas.destroy', $cinema->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-outline-danger" type="submit">Delete</button>
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


