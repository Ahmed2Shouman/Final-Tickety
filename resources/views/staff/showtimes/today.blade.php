@extends('layouts.app')

@section('content')

<div class="container mt-5">
    <h2 class="text-center mb-4" style="color: #333;">Today's Showtimes</h2>

    @if($showtimes->isEmpty())
        <p class="text-center" style="color: #555;">No showtimes available for today.</p>
    @else
        <div class="row">
            @foreach($showtimes as $showtime)
                <div class="col-md-4 mb-4">
                    <div class="card" style="background-color: #2e3b4e; color: #fff;">
                        <div class="card-body">
                            <!-- Movie Title -->
                            <h5 class="card-title" style="color: #f1c40f;">{{ $showtime->movie->title }}</h5>
                            
                            <!-- Showtime Information -->
                            <p class="card-text" style="font-size: 16px;"> 
                                <strong>Time:</strong> {{ \Carbon\Carbon::parse($showtime->start_time)->format('M d, H:i') }} 
                                - {{ \Carbon\Carbon::parse($showtime->end_time)->format('H:i') }}
                            </p>

                            <!-- Language and 3D -->
                            <p class="card-text" style="font-size: 16px;">
                                <strong>Language:</strong> {{ $showtime->language }} <br>
                                <strong>3D:</strong> {{ $showtime->is_3d ? 'Yes' : 'No' }} <br>
                                <strong>Ticket Price:</strong> ${{ number_format($showtime->ticket_price, 2) }}
                            </p>

                            <!-- Cinema and Hall Information -->
                            <div class="d-flex justify-content-between">
                                <span class="badge" style="background-color: #16a085;">
                                    {{ $showtime->hall->name ?? 'N/A' }}
                                </span>
                                <span class="badge" style="background-color: #e74c3c;">
                                    {{ $showtime->cinema->name ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
