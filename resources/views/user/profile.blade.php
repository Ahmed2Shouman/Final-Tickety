@extends('layouts.app')

@section('title', 'User Profile')

@section('content')
<div class="container mt-5">
    <div class="profile-box shadow-sm">
        {{-- Profile Image --}}
        <div class="profile-image">
            <img class="profile-img" src="{{ asset('storage/' . ($user->profile_image ? $user->profile_image : 'profile_images/profile-placeholder.jpg')) }}" alt="Profile Photo">
        </div>

        {{-- Profile Info --}}
        <div class="profile-info">
            <h1 class="fw-bold mb-1">Hello!</h1>
            <p class="text-muted">I'm a registered user of Tickety.</p>
            <p>
                I love going to the movies and managing my bookings with ease. Whether it’s action, drama, or thriller — I’m always up for a good film night.
            </p>
            {{-- User Details --}}
            <div class="profile-details mt-4">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Role:</strong> {{ ucfirst(optional($user->role)->name ?? 'User') }}</p>
                <p><strong>Joined:</strong> {{ $user->created_at->format('F d, Y') }}</p>
            </div>
        </div>
    </div>

    {{-- Update Profile Accordion Section --}}
    <div class="summary-section mt-4">
        <div class="accordion" id="profileAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <h5 class="fw-bold mb-0">Update Profile</h5>
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#profileAccordion">
                    <div class="accordion-body">
                        {{-- Profile Update Form --}}
                        <form method="POST" action="{{ route('user.update_profile', $user->id) }}" style="text-align: center;" enctype="multipart/form-data" id="profileForm">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name', $user->name) }}">
                            </div>

                            <div class="mb-3">
                                <input type="email" name="email" id="email" placeholder="Email" class="form-control" value="{{ old('email', $user->email) }}">
                            </div>

                            <div class="mb-3">
                                <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>

                            <!-- File Upload -->
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="file" name="profile_image" id="profile_image" class="form-control d-none" onchange="checkFileSize()">
                                    <button type="button" class="btn btn-outline-secondary" id="chooseFileButton" onclick="document.getElementById('profile_image').click();">
                                        Choose File
                                    </button>
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


</div>

@endsection

