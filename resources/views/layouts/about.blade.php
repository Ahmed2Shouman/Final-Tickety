@extends('layouts.app')

@section('title', 'About Us - Tickety')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">

            <!-- Page Header -->
            <div class="text-center mb-5" >
                <h1 class="fw-bold display-4">About <span>Tickety</span></h1>
                <p class="text-muted lead">Your ultimate cinema ticketing experience, redefined.</p>
            </div>

            <!-- Who We Are Section -->
            <div class="mb-5">
                <h3 class="fw-semibold mb-3">Who We Are</h3>
                <p class="fs-5 text-muted">
                    Tickety is a smart cinema ticketing platform built to make movie-going seamless for everyone. 
                    Whether you're a customer booking a seat, a cinema admin managing showtimes, or a company 
                    owning a chain of cinemas — Tickety brings everything under one roof.
                </p>
            </div>

            <!-- Our Vision Section -->
            <div class="mb-5">
                <h3 class="fw-semibold mb-3">Our Vision</h3>
                <p class="fs-5 text-muted">
                    To redefine how cinema experiences are managed, booked, and enjoyed using modern, elegant, 
                    and scalable digital solutions.
                </p>
            </div>

            <!-- For Every Role Section -->
            <div class="mb-5">
                <h3 class="fw-semibold mb-3">For Every Role</h3>
                <div class="row">
                    <div class="col-md-3 text-center mb-4">
                        <i class="fas fa-ticket-alt fa-3x mb-2"></i>
                        <h5>🎟 Users</h5>
                        <p class="text-muted">Book tickets, choose seats, view booking history.</p>
                    </div>
                    <div class="col-md-3 text-center mb-4">
                        <i class="fas fa-users-cog fa-3x mb-2"></i>
                        <h5>👨‍🔧 Staff</h5>
                        <p class="text-muted">View shift assignments, manage hall readiness.</p>
                    </div>
                    <div class="col-md-3 text-center mb-4">
                        <i class="fas fa-cogs fa-3x mb-2"></i>
                        <h5>🎬 Admins</h5>
                        <p class="text-muted">Add movies, set showtimes, manage team members.</p>
                    </div>
                    <div class="col-md-3 text-center mb-4">
                        <i class="fas fa-building fa-3x mb-2"></i>
                        <h5>🏢 Superadmins</h5>
                        <p class="text-muted">Manage all connected cinemas and monitor business insights.</p>
                    </div>
                </div>
            </div>

            <!-- Explore Button -->
            <div class="text-center mt-4">
                <a href="{{ route('user.movies.index') }}" class="btn  px-5 py-3 rounded-pill fs-5 shadow-lg hover-effect">Explore Now Showing</a>
            </div>
        </div>
    </div>
</div>
@endsection
