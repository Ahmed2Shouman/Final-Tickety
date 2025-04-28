@extends('layouts.app')

@section('title', 'Edit Staff')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="fw-bold mb-0">Edit Staff: {{ $staff->name }}</h4>
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

            <form method="POST" action="{{ route('admin.manage_staff.updateStaff', $staff->id) }}">
                @csrf
                @method('POST') <!-- Use POST method to handle the update -->

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $staff->name) }}" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $staff->email) }}" required>
                </div>

                <!-- Phone -->
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone', $staff->phone) }}" required>
                </div>

             
                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn">Update Staff</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
