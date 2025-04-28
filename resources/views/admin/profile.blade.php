@extends('layouts.app')

@section('title', 'admin Profile')

@section('content')

<style>
/* Hide the default file input */
input[type="file"].d-none {
    display: none;


    
}

/* Style the file name display */
#fileName {
    cursor: pointer;
    text-align: start;
}

/* Add some spacing between the input and the button */
.input-group .form-control {
    margin-right: 5px;
}

.profile-img {
    height: 400px;
    width: auto;
}
</style>

<div class="container mt-5">
    <div class="profile-box shadow-sm">
        {{-- Profile Image --}}
        <div class="profile-image">
            <img class="profile-img" src="{{ asset('storage/' . ($admin->profile_image ? $admin->profile_image : 'profile_images/profile-placeholder.jpg')) }}" alt="Profile Photo">
        </div>

        {{-- Profile Info --}}
        <div class="profile-info">
            <h1 class="fw-bold mb-1">Hello, {{ $admin->name }}!</h1>
            <p class="text-muted">You're a admin Member at Tickty.</p>

            <p>
                As a admin member, you're part of the team helping ensure smooth operations at Tickty. You can manage and assist users in various sections.
            </p>

            {{-- admin Details --}}
            <div class="profile-details mt-4">
                <p><strong>Name:</strong> {{ $admin->name }}</p>
                <p><strong>Email:</strong> {{ $admin->email }}</p>
                <p><strong>Phone:</strong> {{ $admin->phone }}</p>
                <p><strong>Role:</strong> admin</p>
                <p><strong>Joined:</strong> {{ $admin->created_at->format('F d, Y') }}</p>
            </div>
        </div>
    </div>

    {{-- admin Privileges Section --}}
    <div class="summary-section mt-4">
        <h5 class="fw-bold mb-2">🛠️ admin Privileges</h5>
        <p>As a admin member, you can:</p>
        <ul>
            <li>Assist in managing user queries.</li>
            <li>Perform actions related to bookings and tickets.</li>
        </ul>
    </div>

    {{-- Quick Links Section --}}
    <div class="summary-section mt-4">
        <h5 class="fw-bold mb-2">⚙️ Quick Links</h5>
        <p>Quick access to important sections:</p>
        <ul>
            <li><a href="{{ route('admin.dashboard') }}">Go to Dashboard</a></li>
        </ul>
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
                        <form method="POST" action="{{ route('admin.update_profile', $admin->id) }}" style="text-align: center;" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Name" value="{{ old('name', $admin->name) }}">
                            </div>

                            <div class="mb-3">
                                <input type="email" name="email" id="email" placeholder="Email" class="form-control" value="{{ old('email', $admin->email) }}">
                            </div>

                            <div class="mb-3">
                                <input type="text" name="phone" id="phone" placeholder="Phone" class="form-control" value="{{ old('phone', $admin->phone) }}">
                            </div>

                            <!-- File Upload -->
                            <div class="mb-3">
                                <div class="input-group">
                                    <input type="file" name="profile_image" id="profile_image" class="form-control d-none" onchange="updateFileName()">
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

@endsection

@section('scripts')
<script>
function updateFileName() {
    var fileInput = document.getElementById('profile_image');
    var fileNameDisplay = document.getElementById('fileName');
    var fileName = fileInput.files[0] ? fileInput.files[0].name : 'No file chosen';
    fileNameDisplay.value = fileName; // Update the file name display

    // Handle image preview
    var file = fileInput.files[0];
    var reader = new FileReader();
    if (file) {
        reader.readAsDataURL(file); // Read the file as a data URL (this will be used for the image preview)
    }
}
</script>
@endsection
