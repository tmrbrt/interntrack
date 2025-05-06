@if(Auth::check() && Auth::user()->role === 'student') 
    <div class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 250px; height: 100vh; position: fixed;">
        <h4 class="text-center">Student Panel</h4>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">
              <li class="nav-item">
                <a href="{{ route('student.dashboard') }}" class="nav-link link-dark">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
    <a href="{{ route('attendance.index') }}" class="nav-link link-dark">
         Attendance Tracker
    </a>
</li>

            <li>
                <a href="" class="nav-link link-dark">
                     File Upload System
                </a>
            </li>
            <li>
                <a href="" class="nav-link link-dark">
                    Communication Hub
                </a>
            </li>
        </ul>
    </div>
@endif
