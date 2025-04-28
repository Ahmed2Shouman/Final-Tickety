@extends('layouts.app')

@section('title', 'Manage Staff')

@section('content')




<div class="container mt-5">
    <div class="card shadow-sm">
       <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="fw-bold mb-0">All Staff Members</h4>
                   <a href="{{ route('admin.manage_staff.createStaffForm') }}" class="btn btn-outline">Create Staff</a>
        </div>
        <div class="card-body">
            @if ($staffMembers->isEmpty())
                <p>No staff members found.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                      
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($staffMembers as $staff)
                            <tr>
                                <td>{{ $staff->name }}</td>
                                <td>{{ $staff->email }}</td>
                                <td>{{ $staff->phone }}</td>
                            
                               <td>
                                    <!-- You can add Edit, Delete buttons here if needed -->
                                    <a href="{{ route('admin.manage_staff.viewAssignments', $staff->id) }}" class="btn  btn-sm">View Assignments</a>
                                    <a href="{{ route('admin.manage_staff.edit', $staff->id) }}" class="btn  btn-sm">Edit</a>
                                    <form action="{{ route('admin.manage_staff.delete', $staff->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection
