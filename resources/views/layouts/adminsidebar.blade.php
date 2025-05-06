<div class="d-flex flex-column flex-shrink-0 p-3 bg-dark text-white" style="width: 250px; height: 100vh; position: fixed;">
    <h4 class="text-center">Admin Panel</h4> <!-- Move this outside the <a> -->
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
    <li class="nav-item">
    <a class="nav-link" href="{{ route('admin.userManagement') }}">User Management</a>
</li>
        <li>
        <a href="{{ route('admin.ojt-configuration') }}" class="nav-link text-white">OJT Configuration</a>
        </li>
        <li>
            <a href="{{ route('admin.assignments') }}" class="nav-link text-white">File Management</a>
        </li>
        <li>
            <a href="{{ route('admin.students.index') }}" class="nav-link text-white">Students</a>
        </li>
        <li>
            <a href="{{ route('admin.supervisors.index') }}" class="nav-link text-white">Supervisors</a>
        </li>
        
        <li>
    <a href="{{ route('admin.coordinators.index') }}" class="nav-link text-white">Coordinator</a>
</li>
</div>
