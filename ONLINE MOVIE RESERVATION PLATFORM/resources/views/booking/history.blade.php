@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="overlay">
        <div class="container">
            <h1 class="text-center mb-4 text-white" style="text-shadow: 2px 2px 6px rgba(0,0,0,0.8);">Your Booking History</h1>

            @if (session('success'))
                <div class="alert alert-success fadeIn">
                    {{ session('success') }}
                </div>
            @endif

            @if($bookings->isEmpty())
                <p class="text-white text-center">No bookings found.</p>
            @else
                <div class="row" id="booking-cards">
                    @foreach($bookings as $booking)
                    <div class="col-md-4 mb-3">
                        <div class="card booking-card shadow">
                            <div class="card-header text-white animated-header" style="background: linear-gradient(135deg, #42a5f5, #1e88e5);">
                                <h5 class="mb-0">{{ $booking->showtime->movie->title }}</h5>
                            </div>
                            <div class="card-body">
                                <h6 class="card-title">Showtime: {{ $booking->showtime->showtime }}</h6>
                                <p class="card-text"><strong>Date:</strong> {{ $booking->showtime->date->format('d M Y') }}</p>
                                <p class="card-text"><strong>Selected Seats:</strong> {{ implode(', ', json_decode($booking->selected_seats)) }}</p>
                                <p class="card-text"><strong>Ticket Price:</strong> ${{ number_format($booking->ticket_price, 2) }}</p>
                                <p class="card-text"><strong>Total Price:</strong> ${{ number_format($booking->ticket_price * count(json_decode($booking->selected_seats)), 2) }}</p>
                                <p class="card-text"><strong>Payment Status:</strong> {{ ucfirst($booking->payment_status) }}</p>
                                <a href="{{ route('booking.view', $booking->id) }}" class="btn btn-info view-details-btn">View Details</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Set the background image in the body */
    body {
        background-image: url('/images/user-background.jpg'); /* Ensure this path is correct */
        background-size: cover;
        background-attachment: fixed;
        margin: 0; /* Remove default margin */
        padding: 0; /* Remove default padding */
        color: white; /* Set default text color to white */
    }

    /* Overlay for the container */
    .overlay {
        background-color: rgba(0, 0, 0, 0.7);
        padding: 50px 0;
    }

    /* Container and Background */
    .container-fluid {
        position: relative;
        min-height: 100vh;
        overflow: hidden;
    }

    /* Card styling */
    .booking-card {
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        opacity: 0;
        transform: scale(0.9);
        animation: slideUp 0.5s forwards;
        animation-delay: calc(0.1s * var(--animation-order));
    }

    @keyframes slideUp {
        0% {
            transform: translateY(50px);
            opacity: 0;
        }
        100% {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .animated-header {
        animation: colorShift 5s infinite alternate;
    }

    @keyframes colorShift {
        from {
            background: linear-gradient(135deg, #42a5f5, #1e88e5);
        }
        to {
            background: linear-gradient(135deg, #66bb6a, #43a047);
        }
    }

    .view-details-btn {
        background-color: #42a5f5;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
        box-shadow: 0 8px 15px rgba(66, 165, 245, 0.5);
    }

    .view-details-btn:hover {
        background-color: #1e88e5;
        box-shadow: 0 16px 30px rgba(30, 136, 229, 0.7);
        transform: scale(1.05);
    }

    /* Extra animations */
    @keyframes fadeIn {
        0% {
            opacity: 0;
        }
        100% {
            opacity: 1;
        }
    }

    .fadeIn {
        animation: fadeIn 1s ease forwards;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Apply slide-up effect to each card
        const bookingCards = document.querySelectorAll('.booking-card');
        bookingCards.forEach((card, index) => {
            card.style.setProperty('--animation-order', index);
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });

        // Dynamic alert fade-out after 3 seconds
        const alertBox = document.querySelector('.alert-success');
        if (alertBox) {
            setTimeout(() => {
                alertBox.classList.add('fadeOut');
                alertBox.style.opacity = 0;
            }, 3000);
        }

        // Background parallax effect
        window.addEventListener('scroll', function() {
            const overlay = document.querySelector('.overlay');
            let scrollTop = window.pageYOffset;
            overlay.style.backgroundPositionY = `${scrollTop * 0.5}px`;
        });
    });
</script>
@endsection
