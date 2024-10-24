@extends('layouts.app')

@section('content')
<style>
    /* Full-page background with a gradient overlay */
    body {
        background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url('{{ asset('images/user-background.jpg') }}');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        color: #f8f9fa;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    /* Dashboard layout with sidebar and content */
    .dashboard-container {
        display: flex;
        min-height: 100vh;
        padding-top: 100px; /* Adjusted padding for moving content up */
    }

    /* Sidebar styles with hover animations */
    .sidebar {
        background: rgba(0, 0, 0, 0.9);
        width: 250px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.7);
        position: fixed;
        top: 0;
        bottom: 0;
        transition: width 0.3s;
    }

    .sidebar:hover {
        width: 300px;
    }

    .sidebar h3 {
        color: #ffeb3b;
        text-align: center;
        font-size: 26px;
        font-weight: bold;
        margin-bottom: 40px;
    }

    .sidebar ul {
        list-style-type: none;
        padding: 0;
    }

    .sidebar ul li {
        margin: 20px 0;
    }

    .sidebar ul li a {
        text-decoration: none;
        font-size: 18px;
        color: #ffffff;
        padding: 12px 20px;
        display: block;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .sidebar ul li a:hover {
        background-color: rgba(255, 255, 255, 0.2);
        transform: translateX(15px);
    }

    /* Main content with centered welcome message and adjusted margin */
    .main-content {
        margin-left: 350px; /* Increased distance from sidebar */
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        height: 20vh; /* Decreased height to move content up */
        padding-top: 50px; /* Adjust padding to control vertical position */
        color: white;
        text-align: center;
    }

    .welcome-message {
        font-family: 'Poppins', sans-serif;
        font-size: 45px;
        font-weight: bold;
        color: #ffeb3b;
        margin-bottom: 50px;
        animation: slideDown 1s ease;
    }

    .card {
        background: rgba(0, 0, 0, 0.5);
        border-radius: 20px;
        padding: 50px;
        width: 600px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.6);
        font-family: 'Poppins', sans-serif;
        text-align: center;
        transition: transform 0.5s ease, box-shadow 0.5s ease;
    }

    .card:hover {
        transform: scale(1.1);
    }

    /* Specific styles for the "Discover New Movies" text */
    .card h4, .card p {/* Transparent black background */
        color: white; /* White text */
        font-family: 'Poppins', sans-serif;
        font-size: 20px;
        padding: 10px;
        border-radius: 10px;
    }

    /* Keyframe animations for smooth appearance */
    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="dashboard-container">
    <!-- Sidebar with navigation -->
    <div class="sidebar">
        <h3>User Dashboard</h3>
        <ul>
            <li><a href="{{ route('movies.index') }}">Browse Movies</a></li>
            <li><a href="{{ route('booking.index') }}">Buy Ticket</a></li>
            <li><a href="{{ route('booking.history') }}">My Bookings</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="welcome-message">
            <h2>Welcome, {{ Auth::user()->name }}!</h2>
        </div>

        <div class="card">
            <h4>Discover New Movies</h4>
            <p>Explore the latest movies and manage your bookings easily using the options on the sidebar.</p>
        </div>
    </div>
</div>

<script>
    // JavaScript for hover effects on sidebar
    document.querySelectorAll('.sidebar ul li a').forEach(link => {
        link.addEventListener('mouseover', function() {
            this.style.transform = 'translateX(10px)';
            this.style.transition = 'transform 0.3s ease';
        });
        link.addEventListener('mouseout', function() {
            this.style.transform = 'translateX(0)';
        });
    });
</script>

@endsection
