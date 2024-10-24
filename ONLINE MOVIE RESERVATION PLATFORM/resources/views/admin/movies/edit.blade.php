@extends('layouts.app')

@section('content')
<style>
    body {
        background-image: url('{{ asset('images/admin.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: white;
        font-family: 'Arial', sans-serif;
    }

    .container {
        background: rgba(0, 0, 0, 0.8);
        border-radius: 15px;
        padding: 20px;
        margin-top: 20px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
    }

    h1 {
        font-size: 36px;
        text-align: center;
        margin-bottom: 20px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
    }

    .form-group label {
        font-weight: bold;
    }

    .btn {
        border-radius: 20px;
        transition: background-color 0.3s ease, transform 0.2s;
    }

    .btn-primary {
        background-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    .btn-secondary {
        margin-top: 10px;
    }

    .form-control {
        border-radius: 10px;
        background-color: rgba(255, 255, 255, 0.3);
        color: #fff;
    }
</style>

<div class="container">
    <h1>Edit Movie</h1>
    <form action="{{ route('admin.movies.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $movie->title }}" required>
        </div>

        <div class="form-group">
            <label for="synopsis">Synopsis</label>
            <textarea name="synopsis" id="synopsis" class="form-control" required>{{ $movie->synopsis }}</textarea>
        </div>

        <div class="form-group">
            <label for="genre">Genre</label>
            <input type="text" name="genre" id="genre" class="form-control" value="{{ $movie->genre }}" required>
        </div>

        <div class="form-group">
            <label for="rating">Rating</label>
            <input type="number" name="rating" id="rating" class="form-control" step="0.1" min="0" max="10" value="{{ $movie->rating }}" required>
        </div>

        <div class="form-group">
            <label for="release_date">Release Date</label>
            <input type="date" name="release_date" id="release_date" class="form-control" value="{{ $movie->release_date->format('Y-m-d') }}" required>
        </div>

        <div class="form-group">
            <label for="trailer_link">Trailer Link</label>
            <input type="url" name="trailer_link" id="trailer_link" class="form-control" value="{{ $movie->trailer_link }}" required>
        </div>

        <div class="form-group">
            <label for="imdb_link">IMDb Link</label>
            <input type="url" name="imdb_link" id="imdb_link" class="form-control" value="{{ $movie->imdb_link }}" required>
        </div>

        <div class="form-group">
            <label for="image">Movie Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($movie->image)
                <img src="{{ asset('storage/' . $movie->image) }}" alt="{{ $movie->title }}" class="img-thumbnail mt-2" style="width: 100px; height: auto;">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Movie</button>
        <a href="{{ route('admin.movies.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add custom JavaScript if needed
    });
</script>
@endsection
