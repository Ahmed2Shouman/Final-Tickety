@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header ">
            <h4 class="fw-bold mb-0">Add New Movie</h4>
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

            <form action="{{ route('movies.store') }}" method="POST">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required value="{{ old('title') }}">
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                </div>

                <!-- Duration -->
                <div class="mb-3">
                    <label class="form-label">Duration</label>
                    <div class="d-flex gap-2">
                        <input type="number" name="duration_hours" id="duration_hours" class="form-control" placeholder="Hours" min="0" value="{{ old('duration_hours') }}">
                        <input type="number" name="duration_mins" id="duration_mins" class="form-control" placeholder="Minutes" min="0" max="59" value="{{ old('duration_mins') }}">
                    </div>
                    <small id="duration_hint" class="text-muted">Enter total duration of the movie</small>
                </div>

                <!-- Genre -->
                <div class="mb-3">
                    <label for="genre" class="form-label">Genre</label>
                    <select name="genre" id="genre" class="form-select" required>
                        <option value="">-- Loading genres... --</option>
                    </select>
                </div>

                <!-- Rating -->
                <div class="mb-3">
                    <label for="rating" class="form-label">Rating</label>
                    <select name="rating" id="rating" class="form-select" required>
                        <option value="">-- Select Rating --</option>
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ old('rating') == $i ? 'selected' : '' }}>
                                {{ str_repeat('★', $i) . str_repeat('☆', 5 - $i) }} ({{ $i }} Star{{ $i > 1 ? 's' : '' }})
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Poster -->
                <div class="mb-3">
                    <label for="poster_url" class="form-label">Poster URL</label>
                    <input type="url" name="poster_url" id="poster_url" class="form-control" value="{{ old('poster_url') }}">
                </div>

                <!-- Trailer -->
                <div class="mb-3">
                    <label for="trailer_url" class="form-label">YouTube Trailer URL</label>
                    <input type="url" name="trailer_url" id="trailer_url" class="form-control" value="{{ old('trailer_url') }}" placeholder="https://www.youtube.com/watch?v=xxxxxxx">
                    <small class="text-muted">Paste a full YouTube link like https://www.youtube.com/watch?v=...</small>
                </div>

                <!-- Submit -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Create Movie</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Live duration calculation
        const hoursInput = document.getElementById('duration_hours');
        const minsInput = document.getElementById('duration_mins');
        const hint = document.getElementById('duration_hint');

        function updateHint() {
            const hours = parseInt(hoursInput.value) || 0;
            const minutes = parseInt(minsInput.value) || 0;
            const total = (hours * 60) + minutes;

            hint.textContent = total > 0
                ? `Total Duration: ${total} minute${total > 1 ? 's' : ''}`
                : "Enter total duration of the movie";
        }

        hoursInput.addEventListener('input', updateHint);
        minsInput.addEventListener('input', updateHint);
        updateHint();

        // Load genres from TMDb API
        const genreSelect = document.getElementById('genre');
         const tmdbApiKey = "{{ env('TMDB_KEY') }}"; // Embedding the API key

        fetch(`https://api.themoviedb.org/3/genre/movie/list?api_key=${tmdbApiKey}&language=en-US`)
            .then(response => response.json())
            .then(data => {
                genreSelect.innerHTML = '<option value="">-- Select Genre --</option>';
                data.genres.forEach(genre => {
                    const option = document.createElement('option');
                    option.value = genre.name;
                    option.textContent = genre.name;
                    genreSelect.appendChild(option);
                });

                // Preselect old value if exists
                const oldValue = "{{ old('genre') }}";
                if (oldValue) {
                    genreSelect.value = oldValue;
                }
            })
            .catch(error => {
                console.error('Failed to load genres:', error);
                genreSelect.innerHTML = '<option value="">-- Failed to load genres --</option>';
            });
    });
</script>
@endsection
