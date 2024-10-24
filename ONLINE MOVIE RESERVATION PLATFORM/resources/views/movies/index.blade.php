@extends('layouts.app')

@section('content')
<style>
body {
    background-image: url('images/user-background.jpg'); /* Replace with your image path */
    background-size: cover;
    background-attachment: fixed;
    color: #ffffff;
    font-family: 'Roboto', sans-serif; /* Stylish font */
}

.container {
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 1);
}

.card {
    border: none;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease;
    background: rgba(0, 0, 0, 0.7); /* Transparent white */
}

.card:hover {
    transform: scale(1.05); /* Scale up the card on hover */
    box-shadow: 0 0 50px rgba(0, 0, 0, 0.8);
}

.card-img-top {
    transition: transform 0.3s ease;
}

.card-img-top:hover {
    transform: scale(1.1); /* Slightly zoom the image on hover */
}

.nav-link {
    color: #ffffff;
    transition: color 0.3s ease;
}

.nav-link:hover {
    color: #ffcc00; /* Highlight color on hover */
}

.btn-primary {
    background-color: #ffcc00;
    border: none;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #e6b800; /* Darker shade on hover */
}

.form-control {
    background-color: rgba(255, 255, 255, 0.2); /* Slightly transparent white */
    color: #000;
}

.form-control::placeholder {
    color: #000; /* Placeholder color */
}

/* Add styles for the card header */
.card-header {
    background: rgba(0, 0, 0, 0.5); /* Semi-transparent black */
    color: #ffffff; /* White text for contrast */
    font-weight: bold; /* Bold text */
    font-size: 1.2rem; /* Slightly larger font size */
}

/* Enhance the card body text */
.card-body {
    color: #f0f0f0; /* Light grey text */
}

/* Change font for headings */
.card-title a {
    color: #ffcc00; /* Movie title color */
    text-decoration: none; /* Remove underline */
    transition: color 0.3s ease;
}

.card-title a:hover {
    color: #e6b800; /* Darker shade on hover */
}
</style>

<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card">
                <div class="card-body">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('booking.index') }}">Buy Ticket</a>
                        </li>
                        <!-- Add more links as needed -->
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="col-md-9">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('movies.index') }}" class="mb-3">
                        <input type="text" name="search" placeholder="Search movies..." class="form-control">
                        <button type="submit" class="btn btn-primary mt-2">Search</button>
                    </form>

                    <div class="row">
                        @foreach($movies as $movie)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ asset('storage/' . $movie->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $movie->title }}">
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('movies.show', $movie->id) }}">{{ $movie->title }}</a>
                                    </h5>
                                    <p class="card-text">{{ Str::limit($movie->synopsis, 50) }}</p>
                                    <p class="card-text"><strong>Genre:</strong> {{ $movie->genre }}</p>
                                    <p class="card-text"><strong>Rating:</strong> {{ $movie->rating }}</p>
                                    <p class="card-text"><strong>Release Date:</strong> {{ $movie->release_date->format('d M Y') }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const movieCards = document.querySelectorAll('.card');

    movieCards.forEach(card => {
        card.addEventListener('mouseenter', () => {
            card.style.transition = '0.5s';
            card.style.transform = 'translateY(-5px)'; // Slightly lift the card
        });

        card.addEventListener('mouseleave', () => {
            card.style.transform = 'translateY(0)'; // Reset the card position
        });
    });
});
</script>
@endpush
@endsection
