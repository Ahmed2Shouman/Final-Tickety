@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h4 class="fw-bold mb-0">Create Admin Account</h4>
            <p class="text-muted small mt-1">Only Super Admins can create admin accounts.</p>
        </div>
        <div class="card-body py-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('superadmin.store_admin') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" id="phone" name="phone"
                           class="form-control @error('phone') is-invalid @enderror"
                           value="{{ old('phone') }}" required>
                    @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Salary -->
                <div class="mb-3">
                    <label for="salary" class="form-label">Salary</label>
                    <input type="number" id="salary" name="salary"
                           class="form-control @error('salary') is-invalid @enderror"
                           value="{{ old('salary') }}" required>
                    @error('salary')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

             
                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Create Admin</button>
                </div>

                <!-- Back Link -->
                <div class="text-center mt-3">
                    <a href="{{ route('superadmin.dashboard') }}" class="text-decoration-none small">← Back to Dashboard</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
