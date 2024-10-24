@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background-image: url('images/user-background.jpg'); background-size: cover; background-attachment: fixed; padding: 50px 0;">
    <div class="overlay" style="background-color: rgba(0, 0, 0, 0.7); padding: 50px 0;">
        <div class="container">
            <h1 class="text-center" style="color: #fff; font-size: 2.5em; text-shadow: 2px 2px 6px rgba(0,0,0,0.8);">
                {{ $showtime->movie->title }} - Showtime Details
            </h1>

            <div class="card mb-3" style="background-color: rgba(255,255,255,0.9); border-radius: 15px; box-shadow: 0 8px 15px rgba(0, 0, 0, 0.3);">
                <div class="card-header text-center" style="background: linear-gradient(135deg, #ff9800, #ff5722); color: white; font-size: 1.5em; border-radius: 15px 15px 0 0; padding: 15px;">
                    Showtime Information
                </div>
                <div class="card-body">
                    <p><strong>Showtime:</strong> {{ \Carbon\Carbon::createFromFormat('H:i:s', $showtime->showtime)->format('h:i A') }}</p>
                    <p><strong>Date:</strong> {{ $showtime->date->format('d M Y') }}</p>
                    <p><strong>Seat Capacity:</strong> {{ $showtime->seat_capacity }}</p>
                    <p><strong>Ticket Price:</strong> ${{ number_format($showtime->ticket_price, 2) }}</p>
                </div>
            </div>

            <h2 class="text-center" style="color: #fff; font-size: 2em; text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.5);">Select Your Seats</h2>

            <div id="seating-chart" style="display: flex; justify-content: center; margin-top: 20px;">
                <div id="left-seats" style="display: grid; grid-template-columns: repeat(5, 40px); grid-gap: 10px; margin-right: 50px;"></div>
                <div id="right-seats" style="display: grid; grid-template-columns: repeat(5, 40px); grid-gap: 10px;"></div>
            </div>

            <div id="seat-info" class="text-center mt-3" style="color: #fff; font-size: 1.2em;"></div>

            <form action="{{ route('booking.confirm', $showtime->id) }}" method="POST">
                @csrf
                <input type="hidden" id="selected_seats" name="selected_seats" value="[]">
                <button id="confirm-button" type="submit" class="btn btn-primary mt-3" style="width: 100%; font-size: 1.2em; background-color: #ff5722; border: none;">Confirm Booking</button>
            </form>
        </div>
    </div>

    <style>
        /* Styling the container background */
        .container-fluid {
            position: relative;
            min-height: 100vh;
        }

        /* Adding hover effect to confirm button */
        #confirm-button:hover {
            background-color: #ff9800;
            transition: background-color 0.3s ease;
        }

        /* Seat styling */
        .seat {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 2px solid #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }

        /* Hover effect for available seats */
        .seat:hover:not(.booked) {
            transform: scale(1.1);
            background-color: yellow;
            box-shadow: 0px 4px 10px rgba(255, 255, 0, 0.7);
        }

        /* Selected seat */
        .seat.selected {
            background-color: orange;
            box-shadow: 0px 4px 10px rgba(255, 165, 0, 0.7);
        }

        /* Booked seat (unclickable) */
        .seat.booked {
            background-color: red;
            cursor: not-allowed;
            opacity: 0.7;
        }

        /* Available seat */
        .seat.available {
            background-color: green;
        }

        /* Animations for smoother selection */
        .seat.selected {
            animation: pop-in 0.3s ease-out forwards;
        }

        @keyframes pop-in {
            0% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .seat {
                width: 35px;
                height: 35px;
            }

            #confirm-button {
                font-size: 1em;
            }
        }

        @media (max-width: 576px) {
            .seat {
                width: 30px;
                height: 30px;
            }

            #confirm-button {
                font-size: 0.9em;
            }
        }

        /* Tooltip for seat information */
        .tooltip {
            position: absolute;
            background-color: rgba(0, 0, 0, 0.75);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            pointer-events: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
    </style>

    <script>
        const leftSeatsContainer = document.getElementById('left-seats');
        const rightSeatsContainer = document.getElementById('right-seats');
        const seats = [];
        const availableSeats = @json(json_decode($showtime->selected_seats));

        const tooltip = document.createElement('div');
        tooltip.classList.add('tooltip');
        document.body.appendChild(tooltip);

        function animateSelection(seatElement) {
            seatElement.classList.add('selected');
            seatElement.style.transform = 'scale(1.2)';
            setTimeout(() => {
                seatElement.style.transform = 'scale(1)';
            }, 300);
        }

        function showTooltip(event, text) {
            tooltip.textContent = text;
            tooltip.style.left = event.pageX + 'px';
            tooltip.style.top = (event.pageY - 30) + 'px';
            tooltip.style.opacity = 1;
        }

        function hideTooltip() {
            tooltip.style.opacity = 0;
        }

        function generateSeatingChart(totalSeats) {
            for (let i = 1; i <= totalSeats; i++) {
                const seat = document.createElement('div');
                seat.classList.add('seat');
                seat.setAttribute('data-seat', `Seat ${i}`);
                seat.innerText = `S${i}`;

                // Logic for available or booked seats
                if (availableSeats.includes(`Seat ${i}`)) {
                    seat.classList.add('available');
                    seat.style.backgroundColor = 'green';
                    seat.onclick = function () {
                        const seatNumber = this.getAttribute('data-seat');
                        if (seats.includes(seatNumber)) {
                            this.style.backgroundColor = 'green';
                            seats.splice(seats.indexOf(seatNumber), 1);
                        } else {
                            this.style.backgroundColor = 'orange';
                            animateSelection(this);
                            seats.push(seatNumber);
                        }
                        document.getElementById('selected_seats').value = JSON.stringify(seats);
                        updateSeatInfo();
                    };
                } else {
                    seat.classList.add('booked');
                    seat.style.backgroundColor = 'red';
                    seat.style.cursor = 'not-allowed';
                }

                seat.addEventListener('mouseenter', (e) => {
                    showTooltip(e, `Seat ${i}`);
                });

                seat.addEventListener('mouseleave', hideTooltip);

                if (i <= totalSeats / 2) {
                    leftSeatsContainer.appendChild(seat);
                } else {
                    rightSeatsContainer.appendChild(seat);
                }
            }
        }

        function updateSeatInfo() {
            const seatInfo = document.getElementById('seat-info');
            if (seats.length > 0) {
                seatInfo.innerHTML = `You have selected: <strong>${seats.join(', ')}</strong>`;
            } else {
                seatInfo.textContent = "No seats selected.";
            }
        }

        // Generate the seating chart with a total of 60 seats
        generateSeatingChart(60);
        updateSeatInfo();
    </script>
</div>
@endsection
