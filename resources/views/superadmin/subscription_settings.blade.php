@extends('layouts.app')

@section('title', 'Subscription Settings')

@section('content')

<style>
    /* Plan Cards Style */
    .plan-card {
        background-color: #212529; /* Dark background */
        color: white; /* Text color */
        padding: 20px;
        border-radius: 8px;
        transition: all 0.3s ease;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    .plan-card:hover {
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3); /* Deeper shadow on hover */
        background-color: #343a40; /* Darken on hover */
    }

    .plan-card .plan-title {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .plan-card .btn-choose {
        background-color: #28a745; /* Green background for button */
        color: white;
        border: none;
        border-radius: 5px;
        padding: 10px;
        width: 100%;
        transition: all 0.3s ease;
    }

    .plan-card .btn-choose:hover {
        background-color: #218838; /* Darker green on hover */
    }

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 2px solid #ddd;
    }

    /* Tab Navigation */
    .nav-tabs {
        border-bottom: 2px solid #ddd;
    }

    .nav-link {
        color: #495057;
        font-weight: 600;
    }

    .nav-link.active {
        color: #007bff;
        border-color: #007bff;
    }

    /* Form styling */
    .form-control {
        border-radius: 5px;
        padding: 10px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .btn-custom {
        background-color: #007bff;
        color: white;
        padding: 12px 20px;
        border-radius: 5px;
        font-size: 1.1rem;
    }

    .btn-custom:hover {
        background-color: #0056b3;
    }

</style>

<div class="container mt-5">

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="subscriptionTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="available-plans-tab" data-bs-toggle="tab" href="#available-plans" role="tab" aria-controls="available-plans" aria-selected="true">Available Plans</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="current-subscription-tab" data-bs-toggle="tab" href="#current-subscription" role="tab" aria-controls="current-subscription" aria-selected="false">Current Subscription</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="subscription-history-tab" data-bs-toggle="tab" href="#subscription-history" role="tab" aria-controls="subscription-history" aria-selected="false">Subscription History</a>
        </li>
    </ul>

    <div class="tab-content mt-4" id="subscriptionTabContent">
        
        <!-- Available Subscription Plans -->
        <div class="tab-pane fade show active" id="available-plans" role="tabpanel" aria-labelledby="available-plans-tab">
            <div class="row">
                @foreach($plans as $plan)
                    <div class="col-md-4 mb-4">
                        <div class="plan-card h-100 d-flex flex-column">
                            <h5 class="plan-title text-center">{{ $plan->name }}</h5>
                            <p class="text-center">Description: {{ $plan->description }}</p>
                            <p class="text-center">Price: ${{ $plan->price }}</p>
                            <p class="text-center">Cinemas Included: {{ $plan->cinema_count }}</p>

                            @if($plan->id == $subscription->plan_id)  <!-- Check if it's the current plan -->
                                <button class="btn btn-choose" disabled>Current Plan</button>
                            @else
                                <!-- Redirect to the payment view instead of upgrading the plan directly -->
                                <div class="mt-auto">
                              <form method="POST" action="{{ route('superadmin.checkout', ['planId' => $plan->id]) }}">
                                    @csrf
                                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                                    <button type="submit" class="btn btn-choose w-100">Upgrade to this Plan</button>
                                </form>

                                
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        
        <!-- Current Subscription Details -->
        <div class="tab-pane fade" id="current-subscription" role="tabpanel" aria-labelledby="current-subscription-tab">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Subscription Card -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="card-title text-center">Current Subscription Details</h5>
                </div>
                <div class="card-body">
                    <p><strong>Current Plan:</strong> {{ $subscription->plan->name }}</p>
                    <p><strong>Subscription End Date:</strong> {{ $subscription->subscription_end->format('F j, Y') }}</p>
                    <p><strong>Payment Status:</strong> {{ ucfirst($subscription->payment_status) }}</p>
                    <p><strong>Cinemas Included:</strong> {{ $subscription->cinema_count }}</p>
                </div>
            </div>
        </div>
        
        <!-- Subscription History -->
        <div class="tab-pane fade" id="subscription-history" role="tabpanel" aria-labelledby="subscription-history-tab">
            <h5 class="mb-4">Subscription History</h5>
            <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Plan Name</th>
                        <th>Price</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptionHistory as $history)
                        <tr>
                            <!-- Access the associated plan details from the payment history -->
                            <td>{{ $history->plan->name ?? 'N/A' }}</td> <!-- Display the plan name -->
                            <td>${{ $history->plan->price ?? 'N/A' }}</td> <!-- Display the plan price -->
                            <td>{{ \Carbon\Carbon::parse($history->subscription_start)->format('F j, Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($history->subscription_end)->format('F j, Y') }}</td>
                            <td>{{ ucfirst($history->status) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            </div>
        </div>

    </div>
</div>

@endsection
