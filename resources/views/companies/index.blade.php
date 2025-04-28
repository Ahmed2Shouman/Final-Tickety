@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm border-0">
        <div class="card-header  d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">All Companies</h4>
            <a href="{{ route('companies.create') }}" class="btn btn-primary btn-sm">+ Add New Company</a>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($companies->isEmpty())
                <div class="alert alert-info">No companies found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Total Cinemas</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($companies as $index => $company)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $company->company_name }}</td>
                                    <td>{{ $company->company_email ?? 'N/A' }}</td>
                                    <td>{{ $company->company_phone ?? 'N/A' }}</td>
                                    <td>{{ $company->cinemas->count() }}</td>
                                    <td>
                                        <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form action="{{ route('companies.destroy', $company->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
