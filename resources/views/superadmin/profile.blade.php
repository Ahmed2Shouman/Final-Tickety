@extends('layouts.app')

@section('title', 'Super Admin Profile')

@section('content')


<div class="container mt-5">
    <div class="profile-box shadow-sm">
        {{-- Profile Image --}}
        <div class="profile-image">
<img class="profile-img" src="{{ asset('storage/' . ($superAdmin->profile_image ? $superAdmin->profile_image : 'profile_images/profile-placeholder.jpg')) }}" alt="Profile Photo">

        </div>

        {{-- Profile Info --}}
        <div class="profile-info">
            <h1 class="fw-bold mb-1">Hello, {{ $superAdmin->name }}!</h1>
            <p class="text-muted">You're the Super Admin at Tickty.</p>

            <p>
                As a Super Admin, you have full control over managing all the users, admins, and configurations across the platform. You oversee the overall functionality of Tickty and ensure everything runs smoothly.
            </p>

            {{-- Super Admin Details --}}
            <div class="profile-details mt-4">
                <p><strong>Name:</strong> {{ $superAdmin->name }}</p>
                <p><strong>Email:</strong> {{ $superAdmin->email }}</p>
                <p><strong>Phone:</strong> {{ $superAdmin->phone }}</p>
                <p><strong>Role:</strong> Super Admin</p>
                <p><strong>Joined:</strong> {{ $superAdmin->created_at->format('F d, Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Super Admin Privileges Section --}}
    <div class="summary-section mt-4">
        <h5 class="fw-bold mb-2">🛠️ Super Admin Privileges</h5>
        <p>As a Super Admin, you can:</p>
        <ul>
            <li>Manage users (create, update, delete).</li>
            <li>Assign roles and permissions to admins.</li>
            <li>Access platform settings and configurations.</li>
            <li>View detailed reports about users, bookings, and payments.</li>
        </ul>
    </div>

    {{-- Quick Links Section --}}
    <div class="summary-section mt-4">
        <h5 class="fw-bold mb-2">⚙️ Quick Links</h5>
        <p>Quick access to important sections:</p>
        <ul>
            <li><a href="{{ route('superadmin.manage_admins.index') }}">Manage Admins</a></li>
            <li><a href="{{ route('superadmin.manage_users.index') }}">Manage Users</a></li>
            <li><a href="{{ route('superadmin.dashboard') }}">Go to Dashboard</a></li>
        </ul>
    </div>

<div class="summary-section mt-4">
    {{-- Profile Update Accordion --}}
    <div class="accordion" id="updateProfileAccordion">
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                    <h5 class="fw-bold mb-0">Update Profile</h5>
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#updateProfileAccordion">
                <div class="accordion-body">
                <form method="POST" action="{{ route('superadmin.update_profile', $superAdmin->id) }}" enctype="multipart/form-data" style="text-align: center;">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name', $superAdmin->name) }}">
                        </div>

                        <div class="mb-3">
                            <input type="email" name="email" id="email" placeholder="Email" class="form-control" value="{{ old('email', $superAdmin->email) }}">
                        </div>

                        <div class="mb-3">
                            <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control" value="{{ old('phone', $superAdmin->phone) }}">
                        </div>

                        <!-- HTML -->
                        <div class="mb-3">
                            <div class="input-group">
                                <!-- Custom File Input -->
                                <input type="file" name="profile_image" id="profile_image" class="form-control d-none" onchange="updateFileName()">
                                
                                <!-- Custom button to trigger file input -->
                                <button type="button" class="btn btn-outline-secondary" id="chooseFileButton" onclick="document.getElementById('profile_image').click();">
                                    Choose File
                                </button>

                                <!-- File name display -->
                                <input type="text" class="form-control" id="fileName" placeholder="No file chosen" disabled>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

</div>
@endsection

