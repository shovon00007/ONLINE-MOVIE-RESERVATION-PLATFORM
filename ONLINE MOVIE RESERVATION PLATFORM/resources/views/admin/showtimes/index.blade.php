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

    .btn {
        border-radius: 20px;
        transition: background-color 0.3s ease, transform 0.2s;
        margin-bottom: 10px; /* Space between buttons */
    }

    .btn-primary {
        background-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
        margin-top: 20px;
    }

    thead {
        background-color: rgba(52, 58, 64, 0.9);
    }

    th, td {
        padding: 12px; /* Increased padding */
        text-align: center;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    tr:hover {
        background-color: rgba(255, 255, 255, 0.1);
    }

    .alert {
        margin-bottom: 20px;
        border-radius: 5px;
        opacity: 0.9; /* Semi-transparent alert */
    }
</style>

<div class="container mt-4">
    <h1>Showtimes</h1>
    <a href="{{ route('admin.showtimes.create') }}" class="btn btn-primary">Create Showtime</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Movie</th>
                <th>Showtime</th>
                <th>Date</th>
                <th>Available Seat</th>
                <th>Ticket Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($showtimes as $showtime)
            <tr>
                <td>{{ $showtime->id }}</td>
                <td>{{ $showtime->movie->title }}</td>
                <td>{{ $showtime->showtime }}</td>
                <td>{{ $showtime->date }}</td>
                <td>{{ $showtime->seat_capacity }}</td>
                <td>${{ number_format($showtime->ticket_price, 2) }}</td>
                <td>
                    <a href="{{ route('admin.showtimes.edit', $showtime->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('admin.showtimes.destroy', $showtime->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('admin.home') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script>
    // Add delete confirmation
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to delete this showtime?')) {
                event.preventDefault();
            }
        });
    });
</script>
@endsection
