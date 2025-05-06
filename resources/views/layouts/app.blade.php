<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InternTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <style>
        /* Loader Styling */
        #loader {
            position: fixed;
            width: 100%;
            height: 100%;
            background-color: #121212;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loader-content {
            text-align: center;
            color: #d4a517;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .loader-icon {
            width: 80px;
            height: 80px;
            border: 6px solid rgba(212, 165, 23, 0.2);
            border-top: 6px solid #d4a517;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin-bottom: 15px;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Hide loader when page is loaded */
        .hide-loader {
            opacity: 0;
            visibility: hidden;
            transition: opacity 1.5s ease-out, visibility 1.5s;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100" style="background-color: #121212; color: #fff;">


    <!-- Loader -->
    <div id="loader">
        <div class="loader-content">
            <div class="loader-icon"></div>
            Loading InternTrack...
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg" style="background-color: #1e1e1e;">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('redirect.dashboard') }}" style="color: #d4a517;">InternTrack</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="/">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white fw-bold" href="/about">About</a>
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="nav-link text-white fw-bold" href="/login">Login</a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-bold" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Settings
                            </a>
                            <ul class="dropdown-menu">
                                @if (auth()->user()->role == 'student')
                                    <li><a class="dropdown-item" href="{{ route('profile.show') }}">Student Profile</a></li>
                                @elseif (auth()->user()->role == 'coordinator')
                                    <li><a class="dropdown-item" href="{{ route('profile.show') }}">Coordinator Profile</a></li>
                                @elseif (auth()->user()->role == 'supervisor')
                                    <li><a class="dropdown-item" href="{{ route('profile.show') }}">Supervisor Profile</a></li>
                                @endif
                                <li><a class="dropdown-item" href="{{ route('password.reset') }}">Change Password</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" 
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        Log Out
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <!-- Hidden Log Out Form -->
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @include('layouts.sidebar')
    @yield('content')

    <!-- Footer -->
    <footer class="text-center py-4 mt-5" style="background-color: #1e1e1e; color: #fff;">
        <div class="container">
            <p>&copy; 2025 InternTrack. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Hide loader once the page is fully loaded
        window.addEventListener("load", function() {
            document.getElementById("loader").classList.add("hide-loader");
        });
    </script>

</body>
</html>
