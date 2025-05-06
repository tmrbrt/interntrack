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
        color: #d4a517   !important;
        font-weight: bold;
        background-color: transparent !important; /* Remove Bootstrap's blue background */
    }
</style>

<div class="d-flex flex-column flex-shrink-0 bg-dark text-white"
     style="width: 250px; height: 100vh; position: fixed; top: 0; left: 0; overflow-y: auto; padding-top: 70px; padding-left: 15px; padding-right: 15px;">

    <a href="{{ route('supervisor.dashboard') }}" class="text-center text-decoration-none text-white">
        <h4 class="text-center">Supervisor Panel</h4>
    </a>
    <hr>

    <!-- Sidebar Navigation -->
    <ul class="nav nav-pills flex-column mb-auto mt-3">
        <li>
            <a href="{{ route('supervisor.yourstudents') }}" class="nav-link d-flex align-items-center {{ request()->is('supervisor/yourstudents') ? 'active' : '' }}">
                <i class="bi bi-people-fill me-2"></i> Your Students
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('supervisor.assignments') }}" class="nav-link d-flex align-items-center {{ request()->is('supervisor/assignments') ? 'active' : '' }}">
                <i class="bi bi-journal-text me-2"></i> Student Activities
            </a>
        </li>
        <li>
            <a href="{{ route('supervisor.announcement') }}" class="nav-link d-flex align-items-center {{ request()->is('supervisor/announcement') ? 'active' : '' }}">
                <i class="bi bi-megaphone-fill me-2"></i> Announcement
            </a>
        </li>
        <li>
            <a href="{{ route('supervisor.attendance') }}" class="nav-link d-flex align-items-center {{ request()->is('supervisor/attendance') ? 'active' : '' }}">
                <i class="bi bi-calendar-check-fill me-2"></i> Student Attendance
            </a>
        </li>
        <li>
            <a href="{{ route('evaluation') }}" class="nav-link d-flex align-items-center {{ request()->is('evaluation') ? 'active' : '' }}">
                <i class="bi bi-clipboard-check-fill me-2"></i> Student Evaluation
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

<!-- Include Bootstrap Icons (if not already included in your project) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
