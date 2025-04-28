@extends('layouts.app')

@section('title', 'Help - Tickety')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="text-center mb-4">
                <h1 class="fw-bold">Need Help?</h1>
                <p class="text-muted">We're here to assist you with anything Tickety-related.</p>
            </div>

            <div class="accordion" id="helpAccordion">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            How do I book a movie ticket?
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                            Navigate to the <strong>Now Showing</strong> page, select your movie, choose a time slot and seat, and proceed to payment.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Can I cancel or modify a booking?
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                            Cancellations are allowed up to 1 hour before showtime. Go to <strong>My Bookings</strong> and click "Cancel" next to the ticket.
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Who do I contact for support?
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#helpAccordion">
                        <div class="accordion-body">
                            Please email us at <a href="mailto:support@Tickety.com">support@Tickety.com</a> or call +1 (800) 123-4567.
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <p class="text-muted">Still stuck? Reach out and our team will help you ASAP.</p>
                <a href="mailto:support@Tickety.com" class="btn btn-outline-primary">Contact Support</a>
            </div>
        </div>
    </div>
</div>
@endsection