
@php
    $movies = App\Models\Movie::all();  // Fetch all movies
@endphp



@extends('layouts.app')

@section('content')
<!-- Home Page Content -->
<style>
    @keyframes scrollLeft {
        0% { transform: translateX(0); }
        100% { transform: translateX(-100%); }
    }

    .scroll-slider {
        overflow: hidden;
        position: relative;
        width: 100%;
        height: 500px; /* Set the height to 500px */
    }

    .scroll-track {
        display: flex;
        width: calc(400px * 8);
        animation: scrollLeft 30s linear infinite;
    }

    .scroll-track img {
        width: 100%;
        height: 100%; /* Make the images take the full height of the slider */
        object-fit: cover;
        border-radius: 0; /* Sharp edges */
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
</style>

    

{{-- 

<!-- For all users (logged in or guests) -->
<section class="hero   text-center py-5">

    <div class="container">
        <h1 class="display-4 fw-bold">Welcome to Tickety</h1>
        <p class="lead mb-4">Your one-stop solution for booking and managing movie tickets.</p>
        <p class="mb-4">Explore movies, choose your seats, and complete your payment in just a few clicks.</p>
        <div class="cta-buttons">
            <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg mx-2">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg mx-2">Register</a>
        </div>
    </div>
</section>
--}}


{{-- 
<div class="slider w-full px-0">
    <div class="scroll-slider">
        <div class="scroll-track">
            @for ($i = 0; $i < 10; $i++)
                <img src="{{ asset('Image/Mine.jpg') }}" alt="Image 1">
                <img src="{{ asset('Image/mufasa.jpg') }}" alt="Image 2">
                <img src="{{ asset('Image/sikoo.jpg') }}" alt="Image 3">
                <img src="{{ asset('Image/workk.jpg') }}" alt="Image 4">
            @endfor
        </div>
    </div>
</div>
--}}


 <div class="body-hero"></div>
        <div class="my-10 text-center text-white text-3xl">
            <h1 class="fw-bold"><span>Now Showing</span></h1>
        </div>
        <div class="card-body">
            @if($movies->isEmpty())
                <div class="alert alert-info">No movies available at the moment.</div>
            @else
                <div class="row">
                    @foreach($movies as $movie)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card shadow-sm border-0 rounded-none h-100">
                                <a href="{{ route('user.movies.show', $movie->id) }}" class="stretched-link text-decoration-none">
                                  <img id="movie-poster" class="card-img-top movie-poster" style="height: 350px; object-fit: cover;" alt="{{ $movie->title }} Poster"
                                            src="{{ $movie->poster_url }}" 
                                       >
                                
                                </a>
                                <div class="card-body">
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
 





<section class="features ">
    <div class="container text-center">
        <h2 class="mb-5 display-4 fw-bold section-title ">What We Do</h2>
        
        <!-- First Feature -->
        <div class="row align-items-center mb-5">
            <div class="col-md-6">
                <img src="{{ asset('images/karen-zhao-jLRIsfkWRGo-unsplash.jpg') }}" class=" img-fluid rounded  shadow-sm feature-img  " alt="Feature 1 Image">
            </div>
            <div class="col-md-6 img-desc">
                <h4 class="fw-bold">Cinema's Magic</h4>
                <p>In the dark, the screen comes alive,  
                    A world of stories, where dreams thrive.  
                    Lights, camera, action—magic in the air,  
                    Every frame a tale, beyond compare.  

                    Actors breathe life, emotions unfold,  
                    In every scene, a story is told.  
                    Cinema’s glow, a world to explore,  
                    In every movie, we crave for more.</p>
            </div>
        </div>

        <!-- Second Feature -->

        <div class="row align-items-center mb-5 ">
            <div class="col-md-6 order-md-2">
                <img  src="{{asset('images/3d-rendering-cinema-director-chair.jpg')}}"  class="img-fluid rounded shadow-lg feature-img" style="max-width: 300px;" alt="Feature 2 Image">
            </div>
            <div class="col-md-6 img-desc">
                <h4 class="fw-bold ">Find Your Perfect Spot</h4>
                <p >Unlock a personalized experience—choose your ideal seat with our interactive map. Comfort and convenience await you for an unforgettable movie night.</p>
           
            </div>
        </div>


        <!-- Third Feature -->
   
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    <img src="{{asset('images/ticket-2974645_1920.jpg')}}"  class="img-fluid rounded shadow-lg feature-img" alt="Feature 3 Image">
                </div>
                <div class="col-md-6 img-desc">
                    <h4 class="fw-bold">Seamless Payment Experience</h4>
                    <p >Choose from a variety of secure payment methods—booking your tickets has never been easier. Just a few clicks, and you're ready to enjoy the show.</p>
                </div>
            </div>

    </div>
</section>




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