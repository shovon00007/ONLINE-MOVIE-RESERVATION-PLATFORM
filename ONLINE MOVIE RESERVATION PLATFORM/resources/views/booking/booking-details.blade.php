@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4 neon-text">Thank You for Your Booking!</h1>

    <div class="ticket-card cyberpunk-card shadow-lg">
        <div class="card-header text-center glitch">
            <h5 class="mb-0 neon-text">Booking Details</h5>
        </div>
        <div class="card-body cyberpunk-body">
            <div class="ticket-content">
                <p><strong>Name:</strong> <span class="glitch" data-text="{{ $booking->user_name }}">{{ $booking->user_name }}</span></p>
                <p><strong>Email:</strong> <span class="glitch" data-text="{{ $booking->user_email }}">{{ $booking->user_email }}</span></p>
                <p><strong>Movie:</strong> <span class="glitch" data-text="{{ $booking->movie_name }}">{{ $booking->movie_name }}</span></p>
                <p><strong>Show Date:</strong> <span class="glitch" data-text="{{ $booking->show_date->format('d M Y') }}">{{ $booking->show_date->format('d M Y') }}</span></p>
                <p><strong>Time:</strong> <span class="glitch" data-text="{{ $booking->movie_time }}">{{ $booking->movie_time }}</span></p>
                <p><strong>Ticket Price:</strong> <span class="glitch" data-text="${{ number_format($booking->ticket_price, 2) }}">${{ number_format($booking->ticket_price, 2) }}</span></p>
                <p><strong>Number of Tickets Booked:</strong> <span class="glitch" data-text="{{ $booking->total_seats }}">{{ $booking->total_seats }}</span></p>
                <p><strong>Selected Seats:</strong> <span class="glitch" data-text="{{ implode(', ', json_decode($booking->seat_numbers)) }}">{{ implode(', ', json_decode($booking->seat_numbers)) }}</span></p>
                <p><strong>Total Price:</strong> <span class="glitch" data-text="${{ number_format($booking->ticket_price * $booking->total_seats, 2) }}">${{ number_format($booking->ticket_price * $booking->total_seats, 2) }}</span></p>
            </div>
        </div>
    </div>

    <div class="alert alert-success text-center neon-text mt-3">
        Your booking has been confirmed. Enjoy the movie!
    </div>

    <div class="text-center mt-4">
        <button id="printTicket" class="btn btn-primary neon-btn">Print Ticket</button>
        <a href="{{ route('booking.history') }}" class="btn btn-secondary neon-btn">View Booking History</a>
    </div>
</div>

<style>
    /* Cyberpunk Theme Styles */
    body {
        background-color: #1d1f27;
        color: #fff;
        font-family: 'Orbitron', sans-serif;
    }
    .neon-text {
        font-size: 2em;
        color: #00f6ff;
        text-shadow: 0 0 2px #00f6ff, 0 0 5px #00f6ff, 0 0 10px #ff00ff, 0 0 20px #ff00ff;
    }
    .cyberpunk-card {
        background: linear-gradient(135deg, #0d0d0d 0%, #1b1b1b 100%);
        border: 2px solid #00f6ff;
        border-radius: 10px;
        box-shadow: 0px 0px 15px rgba(0, 255, 255, 0.5), 0 0 20px #ff00ff;
        padding: 20px;
        margin-top: 20px;
    }
    .cyberpunk-body {
        color: #00f6ff;
        font-size: 1.2em;
    }
    .glitch {
        position: relative;
        display: inline-block;
        color: #00f6ff;
        font-weight: bold;
    }
    .glitch::before,
    .glitch::after {
        content: attr(data-text);
        position: absolute;
        left: 0;
        top: 0;
        color: #ff00ff;
        overflow: hidden;
        clip: rect(0, 900px, 0, 0);
    }
    .glitch::before {
        animation: glitch-before 1s infinite linear alternate-reverse;
    }
    .glitch::after {
        color: #00f6ff;
        animation: glitch-after 0.8s infinite linear alternate-reverse;
    }
    @keyframes glitch-before {
        0% {
            clip: rect(0, 900px, 0, 0);
        }
        100% {
            clip: rect(0, 900px, 100px, 0);
        }
    }
    @keyframes glitch-after {
        0% {
            clip: rect(0, 900px, 0, 0);
        }
        100% {
            clip: rect(0, 900px, 50px, 0);
        }
    }
    .alert {
        background-color: #ff00ff;
        color: #fff;
        text-shadow: 0 0 5px #ff00ff;
    }
    .neon-btn {
        background: linear-gradient(90deg, #00f6ff, #ff00ff);
        border: none;
        color: white;
        box-shadow: 0px 0px 15px #ff00ff, 0 0 15px #00f6ff;
        transition: 0.3s ease;
    }
    .neon-btn:hover {
        box-shadow: 0px 0px 20px #ff00ff, 0 0 20px #00f6ff;
    }
    .ticket-content p {
        margin: 10px 0; /* Add more margin to space out the content */
        padding: 5px;
    }
</style>

<script>
    document.getElementById('printTicket').addEventListener('click', function() {
        window.print();
    });

    // Glitch effect script to add randomness
    const glitchElements = document.querySelectorAll('.glitch');
    glitchElements.forEach(el => {
        setInterval(() => {
            el.classList.toggle('glitch-effect');
        }, Math.random() * 2000 + 500);
    });
</script>

@endsection
