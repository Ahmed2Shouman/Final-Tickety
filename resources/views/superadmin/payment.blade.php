@extends('layouts.app')

@section('title', 'Payment for Plan Upgrade')

@section('content')

<style>
    /* Custom plan price style */
    .plan-price {
        color: #ffcc00;
        font-size: 1.5rem;
        font-weight: bold;
    }

    /* Subtle shadow for the plan card */
    .plan-card {
        border-radius: 15px;
        box-shadow: 0px 4px 20px rgba(0, 0, 0, 0.1);
    }

    /* Hover effect for the card */
    .plan-card:hover {
        transform: scale(1.05);
        transition: all 0.3s ease;
    }

    /* Custom button style */
    .btn-choose {
        background-color: #28a745;
        color: white;
        border-radius: 50px;
        padding: 15px 30px;
        font-size: 1.2rem;
        transition: all 0.3s ease;
    }

    /* Hover effect for the payment button */
    .btn-choose:hover {
        background-color: #218838;
        transform: scale(1.05);
    }

    /* Additional section for the icon */
    .plan-info i {
        color: #28a745;
        margin-right: 10px;
    }

    /* Background styling */
    .card-header {
        background: url('https://img.freepik.com/free-photo/popcorn-cinema_23-2147988937.jpg?ga=GA1.1.1595390417.1728447349&w=740') no-repeat center center;
        background-size: cover;
        padding: 30px 0;
    }

    .card-header h4 {
        font-size: 2rem;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6);
    }

</style>

<div class="container mt-5">
    <!-- Card to display the plan upgrade details -->
    <div class="card shadow-lg border-0 plan-card">
        <div class="card-header text-white text-center">
            <h4 class="mb-0"><strong>Upgrade Subscription</strong></h4>
        </div>
        <div class="card-body">
            <!-- Plan Information Section - Left-Aligned -->
            <div class="row">
                <div class="col-md-8">
                    <h5><strong>You are upgrading to the <span class="text-success">{{ $plan->name }}</span> plan</strong></h5>

                    <div class="plan-info mb-3">
                        <p class="text-muted">Description: {{ $plan->description }}</p>
                    </div>

                    <div class="plan-info mb-3">
                          <p class="text-muted">Cinemas Included: <strong>{{ $plan->cinema_count }}</strong></p>
                    </div>

                    <div class="plan-info mb-3">
                        <p class="text-muted">Price: <strong class="plan-price">${{ $plan->price }}</strong></p>
                    </div>
                </div>

                <!-- Payment Button Section - Right-Aligned -->
                <div class="col-md-4 d-flex justify-content-end align-items-center">
                    <form action="{{ route('superadmin.checkout', $plan->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-lg btn-choose shadow-sm">
                            Proceed to Payment {{$plan->id}}
                        </button>
                    </form>
                </div>
            </div>

            <!-- Payment Instructions (below the plan info and button) -->
            <div class="row mt-4">
                <div class="col-md-12 text-center">
                    <p class="text-muted">Once you click the button, you will be redirected to a secure payment gateway.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
