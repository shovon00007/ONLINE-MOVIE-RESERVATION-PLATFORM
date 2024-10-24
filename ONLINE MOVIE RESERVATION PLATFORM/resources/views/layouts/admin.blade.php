<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <!-- Add Bootstrap or other stylesheets here -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2">
                <!-- Admin Sidebar -->
                <nav class="navbar navbar-expand-md navbar-light bg-light">
                    <div class="container">
                        <a class="navbar-brand" href="{{ route('admin.home') }}">Admin Dashboard</a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarAdmin" aria-controls="navbarAdmin" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarAdmin">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.movies.index') }}">Manage Movies</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.showtimes.index') }}">Manage Showtimes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('admin.reports') }}">View Reports</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>

            <div class="col-md-10">
                <!-- Content Section -->
                <div class="content">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Add JavaScript files -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
