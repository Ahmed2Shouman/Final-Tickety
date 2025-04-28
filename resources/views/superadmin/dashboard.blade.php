@extends('layouts.app')

@section('content')
    @php
        use Illuminate\Support\Facades\Auth;
        $user = Auth::user();
    @endphp

    <div class="mt-4">
        <h1>Welcome, Super Admin {{ $user->name ?? 'User' }}</h1>
        <p class="lead">You have full access to the system. Use the tools below to manage everything.</p>
        <h1>super admin</h1>
        <div class="row mt-4">
            <div class="col-md-4">
                <div class="card text-white bg-dark mb-3">
                    <div class="card-header">Manage Admins</div>
                    <div class="card-body">
                        <p class="card-text">Add or remove admins, assign roles, and manage privileges.</p>
                        <a href="{{ route('admin.dashboard') }}" class="btn">Manage Admins</a>
                    </div>
                </div>
            </div>

          
        </div>
    </div>
@endsection
