@extends('layouts.app')

@section('content')
<style>
body {
    background-image: url('{{ asset('images/user-background.jpg') }}'); /* Correctly reference the image */
    background-size: cover;
    background-attachment: fixed;
    color: #ffffff;
    font-family: 'Roboto', sans-serif; /* Stylish font */
}

.container {
    padding: 20px;
}

.card {
    background: rgba(0, 0, 0, 0.8); /* More opaque black for the card background */
    border: none;
    border-radius: 10px;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card-header {
    background: rgba(255, 204, 0, 0.9); /* Highlighted color for the header */
    color: #000; /* Black text for contrast */
    font-weight: bold;
    font-size: 1.5rem; /* Larger font size */
    text-align: center; /* Center the header text */
}

.card-body {
    padding: 20px;
    color: #f0f0f0; /* Light grey text */
}

.card-body img {
    border-radius: 10px; /* Rounded corners for images */
    margin-bottom: 15px; /* Space below the image */
}

.btn {
    margin-right: 10px; /* Space between buttons */
}

.btn-info {
    background-color: #007bff; /* Bootstrap info color */
    border: none;
}

.btn-info:hover {
    background-color: #0056b3; /* Darker shade on hover */
}

.btn-secondary {
    background-color: #6c757d; /* Bootstrap secondary color */
    border: none;
}

.btn-secondary:hover {
    background-color: #5a6268; /* Darker shade on hover */
}

/* Add subtle hover effect for buttons */
.btn:hover {
    transform: scale(1.05);
    transition: transform 0.3s ease;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .img-fluid {
        width: 100%; /* Full width on smaller screens */
        height: auto; /* Maintain aspect ratio */
    }
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
                            <a class="nav-link" href="{{ route('movies.index') }}">Movies</a>
                        </li>
                        <!-- Add more links as needed -->
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-9">
            <div class="card">
                <div class="card-header">{{ $movie->title }}</div>
                <div class="card-body">
                    <img src="{{ asset('storage/' . $movie->image) }}" class="img-fluid" alt="{{ $movie->title }}" style="width: 300px; height: 450px; object-fit: cover;">
                    <p><strong>Synopsis:</strong> {{ $movie->synopsis }}</p>
                    <p><strong>Genre:</strong> {{ $movie->genre }}</p>
                    <p><strong>Rating:</strong> {{ $movie->rating }}</p>
                    <p><strong>Release Date:</strong> {{ $movie->release_date->format('d M Y') }}</p>
                    <a href="{{ $movie->trailer_link }}" class="btn btn-info" target="_blank">Watch Trailer</a>
                    <a href="{{ $movie->imdb_link }}" class="btn btn-secondary" target="_blank">View on IMDb</a>
                    <a href="{{ route('movies.reviews.show', $movie->id) }}" class="btn btn-secondary">View Reviews</a>
                    <a href="{{ route('booking.index') }}" class="btn btn-secondary">Buy Ticket</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const card = document.querySelector('.card');

    // Add subtle lift effect to the card on hover
    card.addEventListener('mouseenter', () => {
        card.style.transform = 'translateY(-5px)'; // Lift the card
        card.style.boxShadow = '0 0 30px rgba(0, 0, 0, 0.8)'; // Enhance shadow
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = 'translateY(0)'; // Reset the card position
        card.style.boxShadow = '0 0 15px rgba(0, 0, 0, 0.5)'; // Reset shadow
    });
});
</script>
@endpush
@endsection
