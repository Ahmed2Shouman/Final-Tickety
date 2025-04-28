@extends('layouts.app')

@section('title', 'User Purchases and Subscription Spending Report')

@section('content')

<div class="container mt-5">
    <h2>User Purchases and Subscription Spending Report</h2>

    <!-- Tab Navigation -->
    <ul class="nav nav-tabs" id="reportTab" role="tablist">
        <li class="nav-item" role="presentation">
            <a class="nav-link active" id="user-purchases-tab" data-bs-toggle="tab" href="#user-purchases" role="tab" aria-controls="user-purchases" aria-selected="true">User Purchases</a>
        </li>
        <li class="nav-item" role="presentation">
            <a class="nav-link" id="subscription-spending-tab" data-bs-toggle="tab" href="#subscription-spending" role="tab" aria-controls="subscription-spending" aria-selected="false">Subscription Spending</a>
        </li>
    </ul>

    <div class="tab-content mt-4" id="reportTabContent">
        
        <!-- User Purchases Tab -->
        <div class="tab-pane fade show active" id="user-purchases" role="tabpanel" aria-labelledby="user-purchases-tab">
            <h4>User Purchases Report</h4>
            <p>Below is a list of all the user purchases:</p>

            <!-- Display total revenue for the current month -->
            <div class="mb-4">
                <h5>Total Revenue for {{ \Carbon\Carbon::now()->format('F Y') }}: ${{ number_format($totalRevenue, 2) }}</h5>
            </div>
            
            <!-- Display user purchases data -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Movie</th>
                        <th>Seats</th>
                        <th>Price</th>
                        <th>Payment Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->user->name }}</td>
                            <td>{{ $booking->user->email }}</td>
                            
                            <!-- Check if showtime and movie exist -->
                            <td>{{ $booking->showtime && $booking->showtime->movie ? $booking->showtime->movie->name : 'N/A' }}</td>

                            <td>{{ implode(', ', $booking->seats) }}</td>
                            <td>${{ $booking->payment->amount ?? 0 }}</td>
                            <td>{{ ucfirst($booking->payment->status ?? 'failed') }}</td>
                            <td>{{ $booking->created_at->format('F j, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Subscription Spending Tab -->
        <div class="tab-pane fade" id="subscription-spending" role="tabpanel" aria-labelledby="subscription-spending-tab">
            <h4>Subscription Spending Report</h4>
            <p>Below is a breakdown of the current logged-in user's spending on subscriptions:</p>

            <!-- Display current user's subscription spending -->
            <div class="mb-4">
                <h5>Total Spending on Subscriptions: ${{ number_format($totalSubscriptionSpending, 2) }}</h5>
            </div>

            <!-- Display subscription spending data -->
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Plan Name</th>
                        <th>Price</th>
                        <th>Subscription Start</th>
                        <th>Subscription End</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subscriptionHistory as $history)
                        <tr>
                            <td>{{ $history->plan->name ?? 'N/A' }}</td>
                            <td>${{ $history->plan->price ?? 0 }}</td>
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

@endsection
