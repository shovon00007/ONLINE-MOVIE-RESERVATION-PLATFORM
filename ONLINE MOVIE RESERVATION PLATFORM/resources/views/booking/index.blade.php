@extends('layouts.app')

@section('content')
<style>
    body {
        background-image: url('images/user-background.jpg'); /* Replace with actual image path */
        background-size: cover;
        background-attachment: fixed;
        background-position: center;
        color: #fff;
        font-family: 'Arial', sans-serif;
    }

    .container {
        background: rgba(0, 0, 0, 0.85); /* Darker overlay */
        padding: 40px;
        border-radius: 15px;
        box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.7);
        animation: zoomIn 1.5s ease-in-out;
    }

    @keyframes zoomIn {
        0% { transform: scale(0); }
        100% { transform: scale(1); }
    }

    h1 {
        text-align: center;
        margin-bottom: 30px;
        font-family: 'Georgia', serif;
        font-size: 2.5em;
        font-weight: bold;
        color: #ffc107;
        text-shadow: 4px 4px 8px rgba(0, 0, 0, 0.8);
        animation: slideInFromRight 1.5s ease-in-out;
    }

    @keyframes slideInFromRight {
        0% { transform: translateX(100%); }
        100% { transform: translateX(0); }
    }

    .card {
        background-color: rgba(255, 255, 255, 0.15);
        border: none;
        border-radius: 10px;
        transition: all 0.4s ease;
        transform: rotateX(0);
        opacity: 0;
        animation: flipIn 0.8s forwards;
    }

    @keyframes flipIn {
        0% { opacity: 0; transform: rotateX(-90deg); }
        100% { opacity: 1; transform: rotateX(0); }
    }

    .card:not(:first-child) {
        margin-top: 25px;
    }

    .card-header {
    background: linear-gradient(135deg, #ff9800, #ff5722); /* Gradient background */
    color: #fff;
    font-size: 1.8em;
    font-family: 'Verdana', sans-serif;
    text-shadow: 2px 2px 6px rgba(0, 0, 0, 0.8);
    padding: 15px 20px;
    border-radius: 10px 10px 0 0;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
    position: relative;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-header::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.3);
    transform: skewX(-45deg);
    transition: left 0.5s ease;
}

.card-header:hover::before {
    left: 100%;
}

.card-header:hover {
    transform: scale(1.05);
    box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.5);
}

/* Adding an icon to the title for extra flair */
.card-header::after {
    content: "\f005"; /* Star icon from FontAwesome */
    font-family: 'FontAwesome';
    position: absolute;
    top: 50%;
    right: 15px;
    font-size: 1.5em;
    color: #ffc107;
    transform: translateY(-50%);
}

/* Add responsive styles */
@media (max-width: 768px) {
    .card-header {
        font-size: 1.5em;
    }

    .card-header::after {
        font-size: 1.2em;
    }
}

    .card-body p {
        font-size: 1.2em;
        line-height: 1.6;
        color: #eee;
        margin: 10px 0;
    }

    .btn-primary {
        background-color: #17a2b8;
        border-color: #17a2b8;
        font-size: 1.3em;
        transition: transform 0.3s ease, box-shadow 0.3s ease, background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #138496;
        transform: scale(1.15);
        box-shadow: 0px 0px 20px rgba(0, 200, 255, 0.8);
    }

    /* Floating and glowing effect for the button */
    .btn-primary {
        animation: floatGlow 3s infinite ease-in-out;
    }

    @keyframes floatGlow {
        0% { transform: translateY(0); box-shadow: 0px 0px 10px rgba(0, 255, 255, 0.3); }
        50% { transform: translateY(-5px); box-shadow: 0px 0px 20px rgba(0, 255, 255, 0.7); }
        100% { transform: translateY(0); box-shadow: 0px 0px 10px rgba(0, 255, 255, 0.3); }
    }

    /* Smooth hover effect for card */
    .card:hover {
        transform: scale(1.05);
        box-shadow: 0px 0px 25px rgba(255, 255, 255, 0.5);
    }
</style>

<div class="container">
    <h1>Book a Ticket</h1>
    @foreach($showtimes as $showtime)
        <div class="card mb-3">
            <div class="card-header">{{ $showtime->movie->title }}</div>
            <div class="card-body">
                <p>Showtime: {{ \Carbon\Carbon::createFromFormat('H:i:s', $showtime->showtime)->format('h:i A') }}</p>
                <p>Date: {{ $showtime->date->format('d M Y') }}</p>
                <p>Seat Capacity: {{ $showtime->seat_capacity }}</p>
                <p>Ticket Price: {{ number_format($showtime->ticket_price, 2) }} TK</p>
                <a href="{{ route('booking.show', $showtime->id) }}" class="btn btn-primary">Select Seats</a>
            </div>
        </div>
    @endforeach
</div>

<script>
    // Parallax scrolling effect
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        document.body.style.backgroundPositionY = -(scrolled * 0.3) + 'px'; // Slower parallax for more depth
    });

    document.addEventListener('DOMContentLoaded', function () {
        const cards = document.querySelectorAll('.card');

        cards.forEach((card, index) => {
            card.style.animationDelay = `${index * 0.3}s`; // Staggered flip-in effect
        });

        const buttons = document.querySelectorAll('.btn-primary');
        buttons.forEach(button => {
            button.addEventListener('mouseover', () => {
                button.classList.add('pulse'); // Pulse animation on hover
            });
            button.addEventListener('mouseleave', () => {
                button.classList.remove('pulse');
            });
        });

        // Flash card effect for attention
        setInterval(() => {
            cards.forEach(card => {
                card.classList.toggle('flash');
            });
        }, 5000); // Flash every 5 seconds for a subtle attention grab
    });

    // Pulse effect for buttons
    document.styleSheets[0].insertRule(`
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }
    `, document.styleSheets[0].cssRules.length);

    // Flash effect for cards
    document.styleSheets[0].insertRule(`
        @keyframes flash {
            0% { box-shadow: 0px 0px 15px rgba(255, 255, 255, 0.3); }
            100% { box-shadow: 0px 0px 30px rgba(255, 255, 255, 0.7); }
        }
    `, document.styleSheets[0].cssRules.length);

    document.styleSheets[0].insertRule(`
        .flash {
            animation: flash 1s infinite alternate;
        }
    `, document.styleSheets[0].cssRules.length);
</script>
@endsection
