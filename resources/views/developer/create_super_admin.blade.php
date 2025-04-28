@extends('layouts.app')

@section('title', 'Create Super Admin')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="fw-bold mb-0">Create Super Admin</h4>
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

            <!-- Display success message -->
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('store_super_admin') }}">
                @csrf
                <div class="row">
                    <!-- Company Fields (Left Side) -->
                    <div class="col-md-6">
                        <!-- Company Name -->
                        <div class="mb-3">
                            <label for="company_name" class="form-label">Company Name</label>
                            <input type="text" name="company_name" id="company_name" class="form-control" required>
                        </div>

                        <!-- Company Email -->
                        <div class="mb-3">
                            <label for="company_email" class="form-label">Company Email</label>
                            <input type="email" name="company_email" id="company_email" class="form-control" required>
                        </div>

                        <!-- Company Phone -->
                        <div class="mb-3">
                            <label for="company_phone" class="form-label">Company Phone</label>
                            <input type="text" name="phone" id="company_phone" class="form-control" required>
                        </div>
                    </div>

                    <!-- Super Admin Fields (Right Side) -->
                    <div class="col-md-6">
                        <!-- Super Admin Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">Super Admin Name</label>
                            <input type="text" name="name" id="name" class="form-control" required>
                        </div>

                        <!-- Super Admin Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Super Admin Email</label>
                            <input type="email" name="email" id="email" class="form-control" required>
                        </div>

                        <!-- Super Admin Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" name="phone" id="phone" class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Create Super Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
