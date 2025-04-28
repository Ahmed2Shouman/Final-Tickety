@extends('layouts.app')

@section('content')


<div class="container mt-5">
    <div class="card shadow-sm border-0">
 <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="mb-0 fw-bold">All Admins</h4>
            <a href="{{ route('superadmin.manage_admins.create') }}" class="btn btn-sm">Creat Admin</a>

        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($admins->isEmpty())
                <div class="alert alert-info">No admin accounts found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Salary</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $index => $admin)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $admin->name }}</td>
                                    <td>{{ $admin->email }}</td>
                                    <td>{{ $admin->salary }}</td>
                                    <td>{{ $admin->created_at->format('Y-m-d') }}</td>
                                     <td>
                                        {{-- Edit button: Pass the admin id to the edit route --}}
                                        <a href="{{ route('superadmin.manage_admins.edit', $admin->id) }}" class="btn btn-sm ">Edit</a>

                                        {{-- Delete button: Pass the admin id to the delete route --}}
                                        <form action="{{ route('superadmin.manage_admins.delete', $admin->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm ">Delete</button>
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
