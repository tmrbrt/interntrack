@if(Auth::check() && Auth::user()->role === 'student')  
    <div class="d-flex flex-column flex-shrink-0 bg-dark text-white"
         style="width: 250px; height: 100vh; position: fixed; top: 0; left: 0; overflow-y: auto; padding-top: 70px; padding-left: 15px; padding-right: 15px;">
        
        <a href="{{ route('student.dashboard') }}" class="text-center text-decoration-none text-white">
            <h4 class="text-center">Student Panel</h4>
        </a>
        <hr>

        <!-- Sidebar Navigation -->
        <ul class="nav nav-pills flex-column mb-auto mt-3">
            <li>
                <a href="{{ route('student.dashboard') }}" class="nav-link d-flex align-items-center {{ request()->is('student/dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill me-2"></i> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('attendance.index') }}" class="nav-link d-flex align-items-center {{ request()->is('attendance') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check-fill me-2"></i> Attendance Tracker
                </a>
            </li>
            <li>
                <a href="{{ route('student.announcements') }}" class="nav-link d-flex align-items-center {{ request()->is('student/announcements') ? 'active' : '' }}">
                    <i class="bi bi-megaphone-fill me-2"></i> Announcements
                </a>
            </li>
            <li>
                <a href="{{ route('student.assignments') }}" class="nav-link d-flex align-items-center {{ request()->is('student/assignments') ? 'active' : '' }}">
                    <i class="bi bi-journal-text me-2"></i> Assignments
                </a>
            </li>
            <li>
                <a href="{{ route('chat.index') }}" class="nav-link d-flex align-items-center {{ request()->is('chat*') ? 'active' : '' }}">
                    <i class="bi bi-chat-dots-fill me-2"></i> Messages
                </a>
            </li>
        </ul>
        <hr>
    </div>
@endif

<!-- Include Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<style>
    /* Default link styles */
    .nav-link {
        color: white !important;
        transition: color 0.3s ease-in-out;
    }

    /* Hover Effect */
    .nav-link:hover {
        color: #d4a517 !important;
    }

    /* Keep active link in yellow */
    .nav-link.active, .nav-link:focus {
        color: #d4a517 !important;
        font-weight: bold;
        background-color: transparent !important; /* Remove Bootstrap's blue background */
    }
</style>
