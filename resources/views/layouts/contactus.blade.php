@extends('layouts.app')

@section('title', 'Contact Us - Tickety')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="text-center mb-4">
                <h1 class="fw-bold">Contact Us</h1>
                <p class="text-muted">We'd love to hear from you. Reach out with questions, feedback, or support needs.</p>
            </div>

            <form method="POST" action="#"> {{-- Replace '#' with a route if backend is set --}}
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" required>
                </div>

                <div class="mb-3">
                    <label for="message" class="form-label">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">Send Message</button>
                </div>
            </form>

            <div class="text-center mt-5">
                <p class="text-muted">Or reach us directly:</p>
                <p>Email: <a href="mailto:support@Tickety.com">support@Tickety.com</a><br>
                   Phone: +1 (800) 123-4567</p>
            </div>
        </div>
    </div>
</div>
@endsection