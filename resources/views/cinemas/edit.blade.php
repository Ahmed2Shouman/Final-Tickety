@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="fw-bold mb-0">Edit Cinema</h4>
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

            <form action="{{ route('cinemas.update', $cinema->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Cinema Name</label>
                    <input type="text" name="name" id="name" class="form-control" required value="{{ old('name', $cinema->name) }}">
                </div>

                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" name="location" id="location" class="form-control" required value="{{ old('location', $cinema->location) }}">
                </div>

                <div class="mb-3">
                    <label for="owner_company_id" class="form-label">Owner Company</label>
                    <select name="owner_company_id" id="owner_company_id" class="form-select" required>
                        <option value="">-- Select Company --</option>
                          @foreach ($companies as $company)
                            <option value="{{ $company->id }}" {{ old('owner_company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->company_name }}
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn">Update Cinema</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
