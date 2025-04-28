@extends('layouts.app') <!-- This extends your main layout, usually found at resources/views/layouts/app.blade.php -->

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Admin Dashboard</h3>
                    </div>
                    <div class="card-body">
                        <h5>Welcome, {{ auth()->user()->name }}!</h5>
                        <p>This is the admin dashboard where you can manage cinemas, movies, and users.</p>

                        <!-- Some admin-specific links or actions -->
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Manage Movies</h5>
                                        <p class="card-text">Add, edit, or remove movies in the system.</p>
                                        <a href="{{ route('movies.index') }}" class="btn">Manage Movies</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Manage Cinemas</h5>
                                        <p class="card-text">Add, edit, or remove cinemas.</p>
                                        <a href="{{ route('cinemas.index') }}" class="btn">Manage Cinemas</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Manage Users</h5>
                                        <p class="card-text">View and manage all users in the system.</p>
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
