@extends('layouts.app')

@section('content')
<!-- Custom CSS for styling -->
<style>
    body {
        background-image: url('{{ asset('images/cineplex-bg.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        color: white;
    }

    .welcome-banner {
        text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.8);
        text-align: center;
        padding: 120px 0;
        font-family: 'Poppins', sans-serif;
    }

    .welcome-text {
        font-size: 50px;
        font-weight: 800;
        letter-spacing: 2px;
        margin-bottom: 30px;
    }

    .explore-text {
        font-size: 26px;
        margin-bottom: 30px;
    }

    .transparent-box {
        background-color: rgba(0, 0, 0, 0.7);
        padding: 40px;
        border-radius: 15px;
        display: inline-block;
    }

    .btn-custom {
        font-size: 22px;
        padding: 15px 40px;
        margin-top: 25px;
        border-radius: 50px;
    }

    .btn-custom:hover {
        background-color: #f7b42c;
        border-color: #f7b42c;
        color: #000;
    }

    .movie-list-container {
        text-align: center;
        margin-top: 60px;
    }

    .movie-list-title {
        font-size: 36px;
        font-weight: 700;
        display: inline-block;
        letter-spacing: 1.3px;
        background-color: rgba(0, 0, 0, 0.6);
        padding: 15px 25px;
        border-radius: 15px;
    }

    .movie-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        margin-bottom: 40px;
        position: relative;
        overflow: hidden;
        border-radius: 10px;
    }

    .movie-card:hover {
        transform: translateY(-12px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
    }

    .movie-img {
        max-height: 380px;
        object-fit: cover;
    }

    .overlay {
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        text-align: center;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        opacity: 0;
        transition: opacity 0.5s ease;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    .movie-card:hover .overlay {
        opacity: 1;
    }

    .btn-movie {
        font-size: 18px;
        padding: 10px 25px;
        margin-top: 15px;
    }
</style>

<!-- Welcome Section -->
<div class="welcome-banner">
    <div class="transparent-box">
        <h1 class="welcome-text">Welcome to CineVerse!</h1>
        <p class="explore-text">Explore the best movies currently available at our theaters.</p>

        <!-- Let's Go Button -->
        @if(auth()->check())
    @if(auth()->user()->type === 'admin')
        <a href="{{ route('admin.home') }}" class="btn btn-lg btn-warning btn-custom">
            Let's Go
        </a>
    @elseif(auth()->user()->type === 'user')
        <a href="{{ route('home') }}" class="btn btn-lg btn-warning btn-custom">
            Let's Go
        </a>
    @elseif(auth()->user()->type === 'manager')
        <a href="{{ route('manager.home') }}" class="btn btn-lg btn-warning btn-custom">
            Let's Go
        </a>
    @else
        <a href="{{ route('login') }}" class="btn btn-lg btn-warning btn-custom">
            Let's Go
        </a>
    @endif
@else
    <a href="{{ route('login') }}" class="btn btn-lg btn-warning btn-custom">
        Let's Go
    </a>
@endif


    </div>
</div>

<!-- Movie List Section -->
<div class="movie-list-container">
    <h2 class="movie-list-title">Now Showing at CineVerse</h2>
</div>

<div class="container mt-5">
    <div class="row mt-4">
        @foreach($movies as $movie)
        <div class="col-md-4">
            <div class="card movie-card shadow">
                <img src="{{ asset('storage/' . $movie->image) }}" class="card-img-top movie-img" alt="{{ $movie->title }}">
                <div class="overlay">
                    <h5 class="text-white">{{ $movie->title }}</h5>
                    <p>{{ Str::limit($movie->synopsis, 100) }}</p>
                    <a href="{{ route('movies.show', $movie->id) }}" class="btn btn-warning btn-movie">View Details</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- JavaScript for dynamic interactions -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.movie-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-12px)';
                this.style.boxShadow = '0 8px 20px rgba(0, 0, 0, 0.5)';
            });
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = 'none';
            });
        });
    });
</script>
@endsection
