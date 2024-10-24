@extends('layouts.app')

@section('content')
<style>
    /* Import Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

    body {
        background-image: url('{{ asset('images/admin.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        color: white;
        font-family: 'Roboto', sans-serif;
    }

    .container {
        background: rgba(0, 0, 0, 0.85);
        border-radius: 15px;
        padding: 20px;
        margin-top: 20px;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.5);
    }

    h1 {
        font-size: 36px;
        text-align: center;
        margin-bottom: 20px;
        text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.7);
    }

    .btn {
        margin-right: 10px;
        border-radius: 20px;
        transition: background-color 0.3s ease, transform 0.2s;
        font-size: 16px; /* Increased button text size */
    }

    .btn-primary {
        background-color: #007bff;
    }

    .btn-primary:hover {
        background-color: #0056b3;
        transform: translateY(-2px);
    }

    .table-wrapper {
        overflow-x: auto;
        margin-top: 20px;
        border-radius: 10px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: rgba(0, 0, 0, 0.95); /* Fully black background for the table */
        color: #ffffff; /* White text for table */
        font-size: 18px; /* Increased font size */
        transition: opacity 0.3s ease;
    }

    thead {
        background-color: rgba(52, 58, 64, 0.9);
    }

    th, td {
        padding: 16px; /* Increased padding for larger text */
        text-align: center;
        position: relative;
        transition: background-color 0.3s;
    }

    th {
        cursor: pointer; /* Indicate sortable columns */
        color: #ffffff; /* White text for table headers */
    }

    tr:nth-child(even) {
        background-color: rgba(255, 255, 255, 0.05); /* Very light background for even rows */
    }

    tr:hover {
        background-color: rgba(255, 255, 255, 0.15);
    }

    img.img-thumbnail {
        border-radius: 10px;
    }

    /* New styling for the table rows */
    tbody tr {
        border: 2px solid transparent; /* Add transparent border for better hover effect */
        border-radius: 10px;
    }

    tbody tr:hover {
        border: 2px solid #007bff; /* Add border on hover */
    }

    /* Add a shadow effect for buttons on hover */
    .btn:hover {
        box-shadow: 0 4px 10px rgba(0, 123, 255, 0.5);
    }
</style>

<div class="container mt-4">
    <h1 class="mb-4">Movies List</h1>

    <a href="{{ route('admin.movies.create') }}" class="btn btn-primary mb-3">Add New Movie</a>

    <div class="table-wrapper">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th onclick="sortTable(0)">Image</th>
                    <th onclick="sortTable(1)">Title</th>
                    <th onclick="sortTable(2)">Synopsis</th>
                    <th onclick="sortTable(3)">Genre</th>
                    <th onclick="sortTable(4)">Rating</th>
                    <th onclick="sortTable(5)">Release Date</th>
                    <th>Trailer Link</th>
                    <th>IMDb Link</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="moviesTableBody">
                @foreach ($movies as $movie)
                <tr>
                    <td>
                        @if($movie->image)
                        <img src="{{ Storage::url($movie->image) }}" alt="{{ $movie->title }}" class="img-thumbnail" style="width: 100px; height: auto;">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                    <td>{{ $movie->title }}</td>
                    <td>{{ Str::limit($movie->synopsis, 50) }}</td>
                    <td>{{ $movie->genre }}</td>
                    <td>{{ $movie->rating }}</td>
                    <td>{{ $movie->release_date->format('d M Y') }}</td>
                    <td><a href="{{ $movie->trailer_link }}" class="btn btn-info btn-sm" target="_blank">Watch Trailer</a></td>
                    <td><a href="{{ $movie->imdb_link }}" class="btn btn-secondary btn-sm" target="_blank">View on IMDb</a></td>
                    <td>
                        <a href="{{ route('admin.movies.edit', $movie->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.movies.destroy', $movie->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm delete-button">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('admin.home') }}" class="btn btn-secondary mt-3">Back to Dashboard</a>
</div>

<script>
    // Add delete confirmation
    document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Are you sure you want to delete this movie?')) {
                event.preventDefault();
            }
        });
    });

    // Sort table function
    function sortTable(columnIndex) {
        const table = document.querySelector('table');
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.rows);
        const isAsc = !table.dataset.sortAsc || table.dataset.sortAsc === "false";
        table.dataset.sortAsc = isAsc;

        rows.sort((a, b) => {
            const aText = a.cells[columnIndex].textContent.trim();
            const bText = b.cells[columnIndex].textContent.trim();
            return isAsc ? aText.localeCompare(bText) : bText.localeCompare(aText);
        });

        rows.forEach(row => tbody.appendChild(row)); // Re-append sorted rows
    }

    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }, 3000);
        });
    });
</script>
@endsection
