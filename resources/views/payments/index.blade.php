@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header ">
            <h4 class="fw-bold mb-0">All Payments</h4>
        </div>
        <div class="card-body">
            @if($payments->isEmpty())
                <div class="alert alert-info">No payments found.</div>
            @else
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>User</th>
                                <th>Booking ID</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $index => $payment)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                          <td>{{ $payment->booking && $payment->booking->user ? $payment->booking->user->name : 'Unknown' }}</td>

                                    <td>{{ $payment->booking_id }}</td>
                                    <td>{{ number_format($payment->amount, 2) }}</td>
                                    <td>{{ ucfirst($payment->method) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $payment->status == 'success' ? 'success' : ($payment->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($payment->status) }}
                                        </span>
                                    </td>
                                   <td>{{ $payment->created_at ? $payment->created_at->format('Y-m-d H:i') : 'N/A' }}</td>

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
