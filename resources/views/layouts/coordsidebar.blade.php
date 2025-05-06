<div class="d-flex flex-column flex-shrink-0 bg-dark text-white"
     style="width: 250px; height: 100vh; position: fixed; top: 0; left: 0; overflow-y: auto; padding-top: 70px; padding-left: 15px; padding-right: 15px;">
    <h4 class="text-center">Coordinator Panel</h4>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="{{ route('coordinator.attendance') }}" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-calendar-check-fill me-2"></i> Student Attendance
            </a>
        </li>
        <li>
            <a href="{{ route('supervisor.announcement') }}" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-megaphone-fill me-2"></i> Announcements
            </a>
        </li>
        <li>
            <a href="{{ route('coordinator.assignments') }}" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-journal-text me-2"></i> Student Assignment
            </a>
        </li>
        <li>
            <a href="{{ route('chat.index') }}" class="nav-link text-white d-flex align-items-center">
                <i class="bi bi-chat-dots-fill me-2"></i> Messages
            </a>
        </li>
    </ul>
    <hr>
</div>

<!-- Include Bootstrap Icons (if not already included) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
