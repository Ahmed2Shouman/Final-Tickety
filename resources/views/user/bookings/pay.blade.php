@extends('layouts.app')

@section('content')


@if ($errors->has('movie'))
    <div class="alert alert-danger">
        {{ $errors->first('movie') }}
    </div>
@endif

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-lg-8">
      <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
          <h4 class="fw-bold mb-0">💳 Payment Confirmation</h4>
          <small>
            Movie: <strong>{{ $movie->title }}</strong> |
            Showtime: {{ \Carbon\Carbon::parse($showtime->start_time)->format('M d, H:i') }}
          </small>
        </div>

        <div class="card-body">
         @php
          $total = request('total_price') ?? 0;
        @endphp

          <form action="{{ route('user.bookings.stripe') }}" method="POST" id="stripe-form">
            @csrf

            {{-- Hidden Inputs --}}
            <input type="hidden" name="movie_id" value="{{ $movie->id }}">
            <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
            <input type="hidden" name="seats" value='@json($seats->pluck("id"))'>
            <input type="hidden" name="stripeToken" id="stripe-token">

            {{-- Seat Summary --}}
            <div class="mb-4">
              <h6>🪑 Seats Chosen</h6>
              <ul class="list-unstyled">
                @foreach($seats as $seat)
                  <li>Row {{ $seat->seat_row }}, Col {{ $seat->seat_column }} ({{ ucfirst($seat->seat_type) }})</li>
                @endforeach
              </ul>
            <input type="hidden" name="price" id="final-price" value="{{ number_format($total, 2, '.', '') }}">

              {{-- Display Calculations --}}
              <p class="h5"><strong>Total:</strong> EGP {{ number_format($total, 2) }}</p>
            </div>

            {{-- Stripe Card Input --}}
            <div class="form-control mb-3" id="card-element"></div>

            {{-- Submit --}}
            <div class="d-grid pt-2">
              <button type="submit" class="btn btn-success btn-lg">✅ Complete Payment</button>
            </div>
          </form>

          <hr>
          <small class="text-muted">You will receive a confirmation once the payment is successful.</small>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://js.stripe.com/v3/"></script>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      // Get your Stripe publishable key from the server or environment
      const stripe = Stripe('{{ env("USER_STRIPE_KEY") }}'); // Ensure your API key is correct
      const elements = stripe.elements();

      // Create a Stripe card element
      const card = elements.create('card');

      // Mount the card input element to the DOM
      card.mount('#card-element');

      const form = document.getElementById('stripe-form');
      const tokenInput = document.getElementById('stripe-token');

      form.addEventListener('submit', function (e) {
          e.preventDefault();  // Prevent default form submission

          form.querySelector('button[type="submit"]').disabled = true;  // Disable the submit button to prevent multiple submissions

          // Create the Stripe token
          stripe.createToken(card).then(function (result) {
              if (result.error) {
                  alert(result.error.message);  // Show error message if token creation fails
                  form.querySelector('button[type="submit"]').disabled = false;  // Re-enable submit button
              } else {
                  // Set the generated token in the hidden input field
                  tokenInput.value = result.token.id;
                  form.submit();  // Now submit the form after the token is added
              }
          });
      });
  });
</script>

@endsection
