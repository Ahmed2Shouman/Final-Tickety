@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="fw-bold mb-0">Add New Company</h4>
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

            <form action="{{ route('companies.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name</label>
                    <input type="text" name="company_name" id="company_name" class="form-control" required value="{{ old('company_name') }}">
                </div>

             <div class="mb-3">
    <label for="company_email" class="form-label">Email</label>
    <input type="email" name="company_email" id="company_email" class="form-control" required value="{{ old('company_email') }}">
    <small class="text-muted">Enter a valid email address (e.g. name@example.com)</small>
</div>

             <div class="mb-3">
    <label for="company_phone" class="form-label">Phone</label>
    <input type="text" name="company_phone" id="company_phone" class="form-control" required value="{{ old('company_phone') }}">
    <small class="text-muted">Phone number must start with 01 and be exactly 11 digits.</small>
</div>


                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Create Company</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
