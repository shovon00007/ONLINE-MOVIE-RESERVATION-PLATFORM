@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background-image: url('/images/user-backgroundjpg'); background-size: cover; background-attachment: fixed; padding: 50px 0;">
    <div class="overlay" style="background-color: rgba(0, 0, 0, 0.7); padding: 50px 0;">
        <div class="container">
            <h1 class="text-center" style="color: #fff; font-size: 2.5em; text-shadow: 2px 2px 6px rgba(0,0,0,0.8);">Booking Confirmation</h1>
            
            <div class="card mb-3" style="background-color: rgba(255, 255, 255, 0.9); border-radius: 15px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #ff9800, #ff5722); color: white; font-size: 1.5em; border-radius: 15px 15px 0 0; padding: 15px;">
                    Showtime Details
                </div>
                <div class="card-body">
                    <p><strong>Movie Title:</strong> {{ $showtime->movie->title }}</p>
                    <p><strong>Showtime:</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $showtime->showtime)->format('h:i A') }}</p>
                    <p><strong>Date:</strong> {{ $showtime->date->format('d M Y') }}</p>
                    <p><strong>Selected Seats:</strong> {{ implode(', ', $selectedSeats) }}</p>
                    <p><strong>Total Seats:</strong> {{ count($selectedSeats) }}</p>
                    <p><strong>Ticket Price:</strong> ${{ number_format($showtime->ticket_price, 2) }}</p>
                    <p><strong>Total Amount:</strong> ${{ number_format($totalAmount, 2) }}</p>
                </div>
            </div>

            <div class="card mb-3" style="background-color: rgba(255, 255, 255, 0.9); border-radius: 15px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #4caf50, #8bc34a); color: white; font-size: 1.5em; border-radius: 15px 15px 0 0; padding: 15px;">
                    User Information
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $userName }}</p>
                    <p><strong>Email:</strong> {{ $userEmail }}</p>
                </div>
            </div>

            <form action="{{ route('booking.store') }}" method="POST">
                @csrf
                <input type="hidden" name="showtime_id" value="{{ $showtime->id }}">
                <input type="hidden" name="selected_seats" value="{{ json_encode($selectedSeats) }}">
                <input type="hidden" name="ticket_price" value="{{ $showtime->ticket_price }}">
                <input type="hidden" name="user_name" value="{{ $userName }}">
                <input type="hidden" name="user_email" value="{{ $userEmail }}">
                <button type="submit" class="btn btn-success btn-block confirm-btn" style="width: 100%; font-size: 1.2em; background-color: #4caf50; border: none; margin-top: 20px; padding: 15px;">Proceed to Payment</button>
            </form>
        </div>
    </div>

    <style>
        .container-fluid {
            position: relative;
            min-height: 100vh;
        }

        /* Card Hover Effect */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 16px 30px rgba(0, 0, 0, 0.2);
        }

        /* Confirmation button styling */
        .confirm-btn {
            background-color: #ff5722;
            font-size: 1.5em;
            color: white;
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 8px 15px rgba(255, 87, 34, 0.5);
        }

        .confirm-btn:hover {
            background-color: #ff9800;
            box-shadow: 0 16px 30px rgba(255, 152, 0, 0.7);
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            h1 {
                font-size: 2em;
            }

            .confirm-btn {
                font-size: 1.2em;
                padding: 12px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add button hover animation
            const confirmButton = document.querySelector('.confirm-btn');
            confirmButton.addEventListener('mouseenter', function() {
                this.style.transform = 'scale(1.05)';
            });

            confirmButton.addEventListener('mouseleave', function() {
                this.style.transform = 'scale(1)';
            });
        });
    </script>
</div>
@endsection
