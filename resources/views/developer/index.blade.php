@extends('layouts.app')

@section('title', 'Developer Dashboard')

@section('content')
<div class="container mt-5">
    <div class="row">
        <!-- Developer Dashboard Welcome Section -->
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="fw-bold mb-0">Welcome to the Developer Dashboard</h4>
                </div>
                <div class="card-body">
                    <p class="mb-0">Here you can manage super admins, cinemas, and other configurations of the system.</p>
                </div>
            </div>
        </div>

        <!-- Dashboard Cards Section -->
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">Super Admins</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Manage all Super Admins and their companies.</p>
                    <a href="{{ route('developer.create_super_admin') }}" class="btn btn-primary">Create Super Admin</a>
                    <a href="{{ route('superadmin.manage') }}" class="btn btn-secondary mt-2">View Super Admins</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">Cinemas</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Manage cinemas and their settings.</p>
                    <a href="{{ route('cinemas.index') }}" class="btn btn-primary">View Cinemas</a>
                    <a href="{{ route('cinemas.create') }}" class="btn btn-secondary mt-2">Create Cinema</a>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">Movies</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">Manage the movies available for screening in cinemas.</p>
                    <a href="{{ route('movies.index') }}" class="btn btn-primary">View Movies</a>
                    <a href="{{ route('movies.create') }}" class="btn btn-secondary mt-2">Create Movie</a>
                </div>
            </div>
        </div>
    </div>

    <!-- System Stats or Notifications Section (Optional) -->
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="fw-bold mb-0">System Stats</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light text-dark">
                                <div class="card-body">
                                    <h5 class="card-title">Total Super Admins</h5>
                                    <p class="card-text">You have 5 super admins.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light text-dark">
                                <div class="card-body">
                                    <h5 class="card-title">Total Cinemas</h5>
                                    <p class="card-text">You have 10 cinemas available.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="card bg-light text-dark">
                                <div class="card-body">
                                    <h5 class="card-title">Total Movies</h5>
                                    <p class="card-text">There are 20 movies in the system.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
