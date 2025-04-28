@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">All Movies</h4>
            <a href="{{ route('movies.create') }}" class="btn btn-primary btn-sm">+ Add New Movie</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($movies->isEmpty())
                <div class="alert alert-info">No movies found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Duration</th>
                                <th>Genre</th>
                                <th>Rating</th>
                                <th>Poster</th>
                                <th>Trailer</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movies as $index => $movie)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $movie->title }}</td>
                                    <td>{{ $movie->duration_minutes }} min</td>
                                    <td>{{ $movie->genre ?? 'N/A' }}</td>
                                    <td>{{ $movie->rating ?? 'N/A' }}</td>
                                    <td>
                                        @if($movie->poster_url)
                                            <img src="{{ $movie->poster_url }}" alt="Poster" width="50">
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($movie->trailer_url)
                                            <a href="{{ $movie->trailer_url }}" target="_blank">Watch</a>
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('movies.edit', $movie->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('movies.destroy', $movie->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this movie?');">
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
