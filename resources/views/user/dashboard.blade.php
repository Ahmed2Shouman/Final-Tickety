@extends('layouts.app')

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
    $user = Auth::user();
@endphp

<div class="container mt-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">👋 Welcome, {{ $user->name ?? 'Guest' }}!</h2>
        <p class="text-muted fs-5">Here you can manage your bookings, view your tickets, and enjoy the show!</p>
    </div>

    <div class="row g-4">
        <!-- My Bookings -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-ticket-perforated-fill fs-1 text-primary"></i>
                    </div>
                    <h5 class="card-title fw-bold">My Bookings</h5>
                    <p class="card-text text-muted">Check your current and past bookings.
                    saddasdasd
                    </p>
                    <a href="{{ route('user.bookings.index') }}" class="btn ">Go to Bookings</a>
                </div>
            </div>
        </div>

        <!-- Browse Movies -->
        <div class="col-md-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body text-center">
                    <div class="mb-3">
                        <i class="bi bi-film fs-1 text-danger"></i>
                    </div>
                    <h5 class="card-title fw-bold">Browse Movies</h5>
                    <p class="card-text text-muted">Explore the latest movies and book your seat.</p>
                    <a href="{{ route('user.movies.index') }}" class="btn">View Movies</a>
                </div>
            </div>
        </div>

       
    </div>
</div>
@endsection
