@extends('layouts.app')

@section('content')
<style>
    /* Reset all default styling */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* Body background */
    body {
        background-image: url('{{ asset('images/admin.jpg') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
        font-family: 'Montserrat', sans-serif;
        color: #ffffff;
        overflow-x: hidden;
    }

    /* Dark overlay for better readability */
    body::before {
        content: '';
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.6);
        z-index: -1;
    }

    /* Navbar adjustments */
    .navbar {
        background-color: rgba(255, 255, 255, 0.2);
        padding: 15px 30px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        font-size: 18px;
    }

    .navbar .navbar-brand {
        font-size: 22px;
        color: #ffffff;
        font-weight: bold;
    }

    .navbar a {
        color: #ffffff;
        padding: 10px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: color 0.3s ease;
    }

    .navbar a:hover {
        color: #ffbe76;
    }

    /* Sidebar styling */
    .sidebar {
    width: 250px;
    background-color: rgba(0, 0, 0, 0.8);
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.5);
    height: 100vh;
    position: fixed;
    left: 0;
    top: 100px; /* Adjust this to move the sidebar down */
    margin-top: 20px; /* Added margin to move sidebar down */
    transition: width 0.3s ease;
}

    .sidebar h3 {
        font-size: 24px;
        color: #ffbe76;
        margin-bottom: 30px;
        text-align: center;
    }

    .sidebar ul {
        list-style: none;
        padding-left: 0;
    }

    .sidebar ul li {
        margin-bottom: 20px;
    }

    .sidebar ul li a {
        font-size: 16px;
        color: #ffffff;
        display: block;
        padding: 10px 20px;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        transition: background 0.3s ease, transform 0.3s ease;
    }

    .sidebar ul li a:hover {
        background-color: #ffbe76;
        color: #272727;
        transform: translateX(10px);
    }

    /* Main content area */
    .main-content {
        margin-left: 270px;
        padding: 50px;
        min-height: 100vh;
        background-color: rgba(255, 255, 255, 0.1);
        border-radius: 20px;
        backdrop-filter: blur(8px);
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.3);
    }

    .main-content h2 {
        font-size: 32px;
        font-weight: 700;
        color: #ffbe76;
        margin-bottom: 20px;
        text-align: center;
    }

    .main-content p {
        font-size: 18px;
        line-height: 1.6;
        color: #fefefe;
        text-align: center;
    }

    /* Cards for different sections */
    .card {
        background-color: rgba(255, 255, 255, 0.1);
        border: none;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        color: #ffffff;
        margin-bottom: 30px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
    }

    .card h3 {
        font-size: 22px;
        margin-bottom: 15px;
        color: #ffbe76;
    }

    .card p {
        font-size: 16px;
    }

    /* Alert for status messages */
    .alert {
        background-color: rgba(255, 183, 77, 0.8);
        padding: 10px 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        text-align: center;
        color: #272727;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            width: 100%;
            height: auto;
            position: relative;
        }

        .main-content {
            margin-left: 0;
            padding: 20px;
        }
    }
</style>

<div class="container-fluid">
    <div class="sidebar">
        <h3>Admin Dashboard</h3>
        <ul>
            <li><a href="{{ route('admin.movies.index') }}">Movies</a></li>
            <li><a href="{{ route('admin.showtimes.index') }}">Showtimes</a></li>
        </ul>
    </div>

    <div class="main-content">
        @if (session('status'))
            <div class="alert">
                {{ session('status') }}
            </div>
        @endif

        <h2>Welcome, Admin!</h2>
        <p>You're logged in as an administrator. Use the sidebar to navigate through the available sections and manage the website efficiently.</p>

        <div class="card">
            <h3>Manage Movies</h3>
            <p>Easily add, update, or remove movies from the system.</p>
        </div>

        <div class="card">
            <h3>Manage Showtimes</h3>
            <p>Update the showtimes for movies and ensure smooth scheduling for the audience.</p>
        </div>
    </div>
</div>
@endsection
