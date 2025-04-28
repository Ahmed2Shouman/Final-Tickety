@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h4 class="fw-bold mb-0">🎬 Now Showing</h4>
            <p class="text-muted small">Browse movies and book your seat instantly</p>
        </div>
        <div class="card-body">
            @if($movies->isEmpty())
                <div class="alert alert-info">No movies available at the moment.</div>
            @else
                <div class="row">
                    @foreach($movies as $movie)
                       <div class="col-md-6 col-lg-4 mb-4 movie">
                            <div class="card h-100 shadow-sm border-0 position-relative">
                                <a href="{{ route('user.movies.show', $movie->id) }}" class="stretched-link text-decoration-none text-dark"></a>
                                @if($movie->poster_url)
                                <img id="movie-poster" class="card-img-top movie-poster" style="height: 350px; object-fit: cover;" alt="{{ $movie->title }} Poster"
                                    src="{{ $movie->poster_url }}">
                                @else
                                    <img src="{{ asset('images/movie_place_holder.png') }}" class="card-img-top" style="height: 350px; object-fit: cover;" alt="Movie Placeholder">
                                @endif
                                <div class="card-body movie-info">
                                    <h5 class="card-title fw-bold">{{ $movie->title }}</h5>
                                    <p class="text-muted mb-1"><strong>Genre:</strong> {{ $movie->genre ?? 'N/A' }}</p>
                                    <p class="text-muted mb-1"><strong>Duration:</strong> {{ $movie->duration_minutes }} mins</p>
                                    <p class="text-muted mb-2"><strong>Rating:</strong> ⭐ {{ $movie->rating }}/5</p>
                                    <p class="small">{{ Str::limit($movie->description, 100) }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection



@section('scripts')


<script>
    // Handle the error event for the movie poster images
    document.querySelectorAll('.movie-poster').forEach(function(img) {
        img.onerror = function() {
            this.src = '{{ asset("images/movie_place_holder.png") }}';
        };
    });
</script>

@endsection