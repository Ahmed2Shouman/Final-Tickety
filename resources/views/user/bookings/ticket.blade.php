@php use SimpleSoftwareIO\QrCode\Facades\QrCode; @endphp

@extends('layouts.app')

@section('content')
<div class="container mt-5">
  <div class="card shadow-lg border-0 rounded-4">
    <div class="card-header bg-gradient bg-success rounded-top-4 py-3 d-flex justify-content-between align-items-center">
      <h4 class="fw-bold mb-0"> Your Ticket</h4>
      <a href="{{ route('user.bookings.index') }}" class="btn btn-sm rounded-pill"> My Bookings</a>
    </div>

    <div class="card-body text-center rounded-bottom-4">
      <h5 class="mb-4 text-success">Thanks for booking, {{ auth()->user()->name }} </h5>

      <div id="ticket" class="ticket shadow-lg p-4 rounded-4 border mx-auto" style="max-width: 750px;">
        <div class="row">
          <!-- Left Section: Ticket Info -->
          <div class="col-md-8">
         

            <ul class="list-unstyled mb-4 text-start">
               <h4 class="fw-bold text-primary mb-3">{{ $movie->title }}</h4>
              <li><strong> Showtime:</strong> {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('M d, H:i') }}</li>
              <li><strong> Hall:</strong> {{ $booking->showtime->hall->name ?? 'N/A' }}</li>
              <li><strong> Seats:</strong>
                @foreach($booking->seats as $seatId)
                  <span class="badge bg-dark me-1">{{ $seatId }}</span>
                @endforeach
              </li>
              <li><strong> Amount Paid:</strong> USD {{ number_format($payment->amount, 2) }}</li>
              <li><strong> Transaction ID:</strong> {{ $payment->transaction_id }}</li>
              <li><strong> Receipt:</strong> <a href="{{ $payment->stripe_receipt_url }}" target="_blank" class="text-primary">View Receipt</a></li>
            </ul>
          </div>

          <!-- Right Section: QR Code -->
          <div class="col-md-4">
            <div class="qr-box border rounded-3 bg-white p-3 text-center mx-auto" style="max-width: 200px;">
              {!! QrCode::size(120)->generate(route('user.bookings.ticket', ['booking_id' => $booking->id])) !!}
              <p class="mt-2 small text-muted">Scan this QR at entry</p>
            </div>

              <!-- Download Ticket Button -->
        <div class="d-flex justify-content-center mt-4">
          <button onclick="downloadTicket()" class="btn btn-outline-primary px-4 rounded-pill shadow-sm">
             Download Ticket
          </button>
        </div>
          </div>
        </div>

      

      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script>
  // Add functionality for downloading ticket as PDF or image
  function downloadTicket() {
    window.print();  // This will open the print dialog where the user can save the ticket as a PDF.
  }
</script>
@endsection
