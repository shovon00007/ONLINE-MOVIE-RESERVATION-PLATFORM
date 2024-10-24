@extends('layouts.app')

@section('content')
<style>
    body {
        background-image: url('{{ asset('images/admin.jpg') }}'); /* Your background image */
        background-size: cover;
        background-position: center;
        color: white;
        font-family: 'Arial', sans-serif;
    }

    .container {
        background: rgba(0, 0, 0, 0.85); /* Semi-transparent black */
        border-radius: 15px;
        padding: 20px;
        margin-top: 20px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
    }

    h1 {
        text-align: center;
        margin-bottom: 20px;
        font-size: 36px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    }

    .form-group {
        margin-bottom: 15px; /* Spacing between form groups */
    }

    .btn {
        border-radius: 20px;
        transition: background-color 0.3s ease;
    }

    .btn-primary {
        background-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .alert {
        margin-bottom: 20px;
        border-radius: 5px;
        opacity: 0.9; /* Semi-transparent alert */
    }

    #seating-chart {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }

    .seat {
        width: 40px;
        height: 40px;
        margin: 5px;
        border: 1px solid #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background-color 0.2s;
    }

    .seat:hover {
        background-color: rgba(255, 255, 255, 0.3);
    }

    .seat-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin: 0 20px; /* Gap of 20px between sections */
    }

    .row {
        display: flex; /* Align seats in a row */
        justify-content: center;
    }
</style>

<div class="container">
    <h1>Create Showtime</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.showtimes.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="movie_id">Select Movie</label>
            <select class="form-control" name="movie_id" id="movie_id" required>
                <option value="">Select a movie</option>
                @foreach($movies as $movie)
                    <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="showtime">Showtime</label>
            <input type="time" class="form-control" name="showtime" id="showtime" required>
        </div>

        <div class="form-group">
            <label for="date">Date</label>
            <input type="date" class="form-control" name="date" id="date" required>
        </div>

        <div class="form-group">
            <label for="seat_capacity">Seat Capacity</label>
            <input type="number" class="form-control" name="seat_capacity" id="seat_capacity" required>
        </div>

        <div class="form-group">
            <label for="ticket_price">Ticket Price</label>
            <input type="number" step="0.01" class="form-control" name="ticket_price" id="ticket_price" required>
        </div>

        <div class="form-group">
            <label for="selected_seats">Seating Arrangement</label>
            <div id="seating-chart">
                <div class="seat-section" id="left-seats"></div>
                <div style="width: 40px;"></div> <!-- Spacer -->
                <div class="seat-section" id="right-seats"></div>
            </div>
        </div>

        <input type="hidden" name="selected_seats" id="selected_seats">

        <button type="submit" class="btn btn-primary">Save Showtime</button>
    </form>

    <a href="{{ route('admin.showtimes.index') }}" class="btn btn-secondary mt-3">Back</a>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script>
    const leftSeatsContainer = document.getElementById('left-seats');
    const rightSeatsContainer = document.getElementById('right-seats');
    const seats = [];

    function generateSeatingChart(totalSeats) {
        for (let i = 1; i <= totalSeats; i++) {
            const seat = document.createElement('div');
            seat.classList.add('seat');
            seat.setAttribute('data-seat', `Seat ${i}`);
            seat.innerText = `S${i}`; // Display seat number

            seat.onclick = function () {
                const seatNumber = this.getAttribute('data-seat');
                if (seats.includes(seatNumber)) {
                    this.style.backgroundColor = ''; // Deselect
                    seats.splice(seats.indexOf(seatNumber), 1);
                } else {
                    this.style.backgroundColor = 'green'; // Select
                    seats.push(seatNumber);
                }
                document.getElementById('selected_seats').value = JSON.stringify(seats); // Update hidden input
            };

            // Add seats to left or right
            if (i <= 30) {
                if (i % 5 === 1) { // Start a new row every 5 seats
                    const row = document.createElement('div');
                    row.classList.add('row');
                    leftSeatsContainer.appendChild(row);
                }
                leftSeatsContainer.lastChild.appendChild(seat); // Add to the last row
            } else {
                if (i % 5 === 1) { // Start a new row every 5 seats
                    const row = document.createElement('div');
                    row.classList.add('row');
                    rightSeatsContainer.appendChild(row);
                }
                rightSeatsContainer.lastChild.appendChild(seat); // Add to the last row
            }
        }
    }

    generateSeatingChart(60); // Total seats = 60 (30 left + 30 right)
</script>

@endsection
