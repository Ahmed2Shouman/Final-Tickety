@extends('layouts.app')

@section('title', 'Payment Success')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header text-center bg-success text-white">
            <h4>Payment Successful!</h4>
        </div>
        <div class="card-body">
            <div class="text-center">
                <h5>Your subscription has been successfully upgraded!</h5>
                <p>Thank you for your payment.</p>
                
                <hr>

                <h6>Subscription Details:</h6>
                <ul class="list-unstyled">
                    <li><strong>Plan:</strong> {{ $userSubscription->plan->name ?? 'N/A' }}</li>
                    <li><strong>Price:</strong> ${{ $userSubscription->plan->price ?? 'N/A' }}</li>
                    <li><strong>Start Date:</strong> {{ $userSubscription->subscription_start ? $userSubscription->subscription_start->format('M d, Y') : 'Not available' }}</li>
                    <li><strong>Start Date:</strong> {{ $userSubscription->subscription_end ? $userSubscription->subscription_end->format('M d, Y') : 'Not available' }}</li>
                    <li><strong>Status:</strong> {{ ucfirst($userSubscription->status ?? 'unknown') }}</li>
                </ul>

                <a href="{{ route('superadmin.dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection
