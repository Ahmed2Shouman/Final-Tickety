@extends('layouts.app')

@section('content')
<style>
.legend-item {
    display: flex;
    align-items: center; /* vertically center */
    gap: 8px; /* space between seat and text */
}

.legend-item p {
    margin: 0; /* remove default margin from <p> */
}


.price{
    color: white !important;
}

</style>


<div class="container  movie-details">
    <div class="row">
        <!-- Left Section: Movie Info -->
        <div class="col-md-6 movie-details-card">
            <div class="movie-info">
                
                @if($movie->poster_url)
                <img id="movie-poster" class="card-img-top movie-poster" style="height: 350px; object-fit: cover;" alt="{{ $movie->title }} Poster"
                    src="{{ $movie->poster_url }}">
                @else
                    <img src="{{ asset('images/movie_place_holder.png') }}" class="card-img-top" style="height: 350px; object-fit: cover;" alt="Movie Placeholder">
                @endif


                 
               <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <div class="movie-meta">
                      <h2 class="movie-title">{{ $movie->title }}</h2>
                      <p><strong>Genre:</strong> {{ $movie->genre }}</p>
                      <p><strong>Duration:</strong> {{ $movie->duration_minutes }} minutes</p>
                      <p><strong>Rating:</strong> {{ $movie->rating }}/5</p>
                  </div>

                  @if($movie->trailer_url)
                      <div class="ms-auto">
                          <a href="{{ $movie->trailer_url }}" target="_blank" class="btn btn-trailer">🎬 Watch Trailer</a>
                      </div>
                  @endif
              </div>

                <p class="movie-desc">{{ $movie->description }}</p>

              
            </div>
        </div>




        <!-- Right Section: Booking Form -->
        <div class="col-md-6">
            <div class="booking-form">
                <h2 class="form-title">Book Your Tickets</h2>
                <form id="bookingForm" method="GET" action="{{ route('user.bookings.pay') }}">
                  @csrf

                    <input type="hidden" name="movie_id" value="{{ $movie->id }}">

                    <div class="form-group">
                        <!-- Select Theater -->
                        <select id="theater" class="form-control" required>
                            <option value="">Select Theater</option>
                            @foreach($movie->showtimes as $showtime)
                                @if($showtime->hall) <!-- Ensure hall is not null -->
                                    <option value="{{ $showtime->hall->name }}">
                                        {{ $showtime->hall->name }} - 
                                        (Seats Available: {{ $showtime->hall->seats->count() }})
                                    </option>
                                @else
                                    <option value="">No Theater Available</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <!-- Select Show Time -->
                       <select id="time" class="form-control" required>
                            <option value="">Select Show Time</option>
                            @foreach($movie->showtimes as $showtime)
                                <option 
                                    value="{{ $showtime->id }}" 
                                    data-id="{{ $showtime->id }}"  
                                    data-price="{{ $showtime->ticket_price }}"
                                    data-hall-name="{{ $showtime->hall->name }}"
                                    data-hall-id="{{ $showtime->hall->id }}"
                                >
                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('M d, H:i') }} 
                                    ({{ $showtime->hall->name }}) 
                                    ({{ $showtime->language }} {{ $showtime->is_3d ? '| 3D' : '' }})
                                </option>
                            @endforeach
                        </select>

                           <input type="hidden" name="showtime_id" id="showtimeInput" value="">
                    </div>

                    <!-- Seat Selection -->
                    <div class="screen-container">
                        <div class="screen">SCREEN</div>

                        <!-- Seats Container -->
                        <div class="seats-container-wrapper position-relative">
                          <div id="seatsOverlay" class="position-absolute w-100 h-100 bg-light bg-opacity-75 d-flex justify-content-center align-items-center" style="z-index: 10;">
                            <div class="text-muted fw-bold">Please select theater and showtime first</div>
                          </div>

                        <div class="seats-container pt-5 pd-3">
                            @foreach($movie->showtimes as $showtime)
                                @if($showtime->hall)
                                    @php
                                        $assignedSeats = $showtime->hall->seats->where('seat_type', '!=', 'not_assigned');
                                    @endphp
                                    <div class="seat-grid d-none" id="seats-showtime-{{ $showtime->id }}">
                                        @foreach($assignedSeats->chunk($showtime->hall->seat_column_count) as $seatRow)
                                            <div class="seat-row text-light">
                                                <h3>{{ $loop->iteration }}</h3>
                                                @foreach($seatRow as $seat)
                                                    <div
                                                        class="seat {{ $seat->seat_type }} {{ $seat->is_available ? 'available' : 'occupied' }}"
                                                        data-seat-id="{{ $seat->id }}"
                                                        data-seat-price="{{ $seat->seat_price }}"
                                                    ></div>
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endforeach
                        </div>

                      </div>


                        
                        <!-- Seat Legend -->
                        <div class="seat-legend pt-4">
                            <div class="legend-item">
                                <div class="seat legend selected"></div>
                                <p>Selected</p>
                            </div>
                            <div class="legend-item">
                                <div class="seat legend bg-light"></div>
                                <p>Available</p>
                            </div>
                            <div class="legend-item">
                                <div class="seat legend occupied "></div>
                                <p>Occupied</p>
                            </div>

                             <div class="legend-item">
                                <div class="seat legend vip "></div>
                                <p>Vip</p>
                            </div>
                               <div class="legend-item">
                                <div class="seat legend standard "></div>
                                <p>Standard</p>
                            </div>
                        </div>

                    </div>

                    <!-- Booking Summary -->
                    <div class="booking-summary">
                        <h3 class="summary-title">Booking Summary</h3>
                        <div class="summary-item">
                            <span class="price" >Tickets</span>
                            <span id="ticketPrice">0</span>
                        </div>
                        <div class="summary-item">
                            <span class="price">Service Fee</span>
                            <span id="serviceFee">0</span>
                        </div>
                        <div class="summary-total">
                            <span class="price">Total</span>
                            <span id="totalPrice">0</span>
                        </div>
                    </div>


                    {{-- Hidden input to store the array of selected seat IDs for form submission --}}
                    <input type="hidden" id="selectedSeats" name="seats" value="[]">
                    <input type="hidden" name="total_price" id="totalPriceInput" value="">



                    <!-- Centered Button -->
                    <div class="form-group d-flex justify-content-center mt-4">
                        <button type="submit" class="btn btn-success btn-lg btn-block">Pay</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection







@section('scripts')




<script>
    // Handle the error event for the movie poster images
    document.querySelectorAll('.movie-poster').forEach(function(img) {
        img.onerror = function() {
            this.src = '{{ asset("images/movie_place_holder.png") }}';
        };
    });
</script>



<script>

document.addEventListener('DOMContentLoaded', () => {
    // 🔹 Element Selectors
    const bookingForm = document.getElementById('bookingForm');
    const theaterSelect = document.getElementById('theater');
    const timeSelect = document.getElementById('time');
    const hiddenInput = document.getElementById('selectedSeats');
    const showtimeInput = document.getElementById('showtimeInput');
    const summaryPrice = document.getElementById('ticketPrice');
    const summaryFee = document.getElementById('serviceFee');
    const summaryTotal = document.getElementById('totalPrice');
    const overlay = document.getElementById('seatsOverlay');

    let selected = [];
    let hasUserInteracted = false;

    // 🚫 Remove warning when submitting the form
    bookingForm.addEventListener('submit', () => {
        window.removeEventListener('beforeunload', handleBeforeUnload);
    });

    // ⚠️ Warn user if trying to refresh or leave before submitting
    function handleBeforeUnload(e) {
        if (hasUserInteracted) {
            e.preventDefault();
            e.returnValue = '';
            return '';
        }
    }
    window.addEventListener('beforeunload', handleBeforeUnload);

    // 🔸 Enable/Disable Seats Overlay
    function checkSelectionsAndEnableSeats() {
        const theaterSelected = theaterSelect.value.trim() !== '';
        const timeSelected = timeSelect.value.trim() !== '';
        overlay?.classList.toggle('d-none', theaterSelected && timeSelected);
    }

    checkSelectionsAndEnableSeats();

    theaterSelect.addEventListener('change', () => {
        hasUserInteracted = true;
        checkSelectionsAndEnableSeats();
    });

    timeSelect.addEventListener('change', () => {
        const selectedOption = timeSelect.selectedOptions[0];
        const showtimeId = selectedOption?.dataset.id || '';

        // ✅ Hide all seat grids
        document.querySelectorAll('.seat-grid').forEach(el => el.classList.add('d-none'));

        // ✅ Show only the grid for the selected showtime
        const activeSeatGrid = document.getElementById(`seats-showtime-${showtimeId}`);
        if (activeSeatGrid) {
            activeSeatGrid.classList.remove('d-none');
        }

        hasUserInteracted = true;
        showtimeInput.value = showtimeId;
        checkSelectionsAndEnableSeats();
        updateSummary();

        // After grid is displayed, bind seat click events
        bindSeatClickEvents();
    });

    // 💳 Update Price Summary
    function updateSummary() {
        const showtimePrice = parseFloat(timeSelect.selectedOptions[0]?.dataset.price || 0);
        let seatTotal = 0;

        selected.forEach(id => {
            const seatEl = document.querySelector(`.seat[data-seat-id="${id}"]`);
            if (seatEl) seatTotal += parseFloat(seatEl.dataset.seatPrice || 0);
        });

        const subTotal = (showtimePrice * selected.length) + seatTotal;
        const fee = subTotal * 0.12;
        const total = subTotal + fee;

        summaryPrice.textContent = subTotal.toFixed(2);
        summaryFee.textContent = fee.toFixed(2);
        summaryTotal.textContent = total.toFixed(2);
        document.getElementById('totalPriceInput').value = total.toFixed(2);
    }

    // 🎟️ Seat Toggle Handler
    function toggleSeat(seatEl) {
        hasUserInteracted = true;
        const id = seatEl.dataset.seatId;
        const selectedNow = seatEl.classList.toggle('selected');

        if (selectedNow) {
            selected.push(id);
        } else {
            selected = selected.filter(x => x !== id);
        }

        hiddenInput.value = JSON.stringify(selected);
        updateSummary();
    }

    // 🪑 Bind Click Events to Available Seats
    function bindSeatClickEvents() {
        document.querySelectorAll('.seat.available').forEach(seat => {
            seat.addEventListener('click', () => toggleSeat(seat));
        });
    }

    // 🚀 Init
    updateSummary();
});

</script>
@endsection
