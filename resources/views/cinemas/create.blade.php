@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="fw-bold mb-0">Add New Cinema</h4>
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

            <form action="{{ route('cinemas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="name" class="form-label">Cinema Name</label>
                    <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" id="location" class="form-control" required value="{{ old('location') }}">
                </div>

                 <!-- Hidden Company ID (Automatically added in Controller) -->
                <input type="hidden" name="company_id" value="{{ $company->id }}">

                <div class="d-grid">
                    <button type="submit" class="btn btn-success">Create Cinema</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
