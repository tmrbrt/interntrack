<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StudentDashboardController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CoordinatorDashboardController;
use App\Http\Controllers\SupervisorDashboardController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\StudentAssignmentController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\CoordinatorProfileController;
use App\Http\Controllers\CoordinatorController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SupervisorProfileController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\OjtConfigurationController;
use App\Http\Controllers\StudentProgressController;
use App\Http\Controllers\AdminStudentController;
use App\Http\Controllers\AdminSupervisorController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\AdminCoordinatorController;
use App\Models\Announcement;
use App\Models\Assignment;
use App\Models\StudentProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Login Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Register Routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

//student User
Route::get('/profile/setup', [StudentProfileController::class, 'showProfileSetupForm'])->name('student.profile.setup');


// Authentication Routes
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    // Show the profile setup form
    Route::get('/student/profile/setup', [StudentProfileController::class, 'showProfileSetupForm'])
        ->name('student.profile.show');

    // Handle profile setup submission
    Route::post('/student/profile/setup', [StudentProfileController::class, 'store'])
        ->name('student.profile.setup');

Route::get('/dashboard', function () {
        return view('dashboard'); // Make sure this view exists in resources/views/dashboard.blade.php
    })->name('dashboard')->middleware('auth');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'role:coordinator'])->group(function () {
    Route::get('/coordinator/dashboard', [CoordinatorController::class, 'index'])->name('coordinator.dashboard');
    });
    
Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    });
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});

    Route::get('/student/profile/setup', [StudentProfileController::class, 'setup'])->name('student.profile.setup');
    Route::get('/supervisor/dashboard', [SupervisorDashboardController::class, 'index'])->name('supervisor.dashboard');
    Route::get('/coordinator/dashboard', [CoordinatorDashboardController::class, 'index'])->name('coordinator.dashboard');
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');;

Route::get('/coordinator/dashboard', [CoordinatorDashboardController::class, 'index'])
    ->name('coordinator.dashboard');

Route::middleware(['auth'])->group(function () {
        Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
        Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store');
    
    
Route::get('/attendance/data', [AttendanceController::class, 'fetchAttendance'])->name('attendance.data');


Route::middleware(['auth'])->group(function () {
    Route::get('/student/dashboard', [DashboardController::class, 'index'])->name('student.dashboard');
});

Route::get('/supervisor/dashboard', [SupervisorDashboardController::class, 'index'])
    ->name('supervisor.dashboard');

    
Route::middleware(['auth', 'role:student'])->group(function () {
        Route::get('/student/attendance', [AttendanceController::class, 'studentAttendance'])->name('student.attendance.index');
    });

Route::get('/coordinator/attendance', [AttendanceController::class, 'index'])->name('coordinator.attendance');
});


Route::middleware(['auth'])->group(function () {
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/student/assignments', [StudentAssignmentController::class, 'index'])->name('student.assignments');
});

Route::middleware(['auth',RoleMiddleware::class . ':supervisor'])->group(function () {
    Route::get('/supervisor/assignments', [AssignmentController::class, 'index'])->name('supervisor.assignments');
    Route::post('/supervisor/assignments', [AssignmentController::class, 'store'])->name('supervisor.assignments.store');
});

Route::middleware(['auth', RoleMiddleware::class . ':supervisor'])->group(function () {
    Route::get('/supervisor/profile/setup', [SupervisorController::class, 'setupProfile'])->name('supervisor.profile.setup');
    Route::post('/supervisor/profile/setup', [SupervisorProfileController::class, 'store'])->name('supervisor.profile.setup');
    Route::post('/supervisor/profile/setup', [SupervisorController::class, 'storeProfile'])->name('supervisor.profile.store');
});

Route::middleware(['auth', RoleMiddleware::class . ':coordinator'])->group(function () {
    Route::get('/coordinator/profile/setup', [CoordinatorProfileController::class, 'setupProfile'])->name('coordinator.profile.setup');
    Route::post('/coordinator/profile/setup', [CoordinatorProfileController::class, 'storeProfile'])->name('coordinator.profile.store');
});
Route::middleware(['auth', RoleMiddleware::class . ':student'])->group(function () {
    Route::get('/student/assignments', function () {
        $announcements = Announcement::latest()->get();
        $assignments = Assignment::with(['supervisor', 'submissions'])->latest()->get();
        return view('student.assignments', compact('announcements', 'assignments'));
    })->name('student.assignments');
});

Route::middleware(['auth', RoleMiddleware::class . ':student'])->group(function () {
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
});

Route::get('/supervisor/announcement', [SupervisorController::class, 'announcement'])->name('supervisor.announcement');
Route::get('/student/announcements', [AnnouncementController::class, 'index'])->name('student.announcements');




Route::middleware(['auth'])->group(function () {
    Route::get('/supervisor/announcements', [AnnouncementController::class, 'index'])->name('supervisor.announcements');
    Route::post('/announcements/store', [AnnouncementController::class, 'store'])->name('announcements.store');
    Route::get('/announcements/{id}/edit', [AnnouncementController::class, 'edit'])->name('announcements.edit');
    Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');
    Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

});
Route::get('/supervisor/attendance', [AttendanceController::class, 'supervisorView'])->name('supervisor.attendance');
Route::get('/supervisor/attendance', [SupervisorController::class, 'showAttendance'])->name('supervisor.attendance');

Route::middleware(['auth',RoleMiddleware::class . ':coordinator'])->group(function () {
    Route::get('/coordinator/attendance', [AttendanceController::class, 'coordinatorView'])->name('coordinator.attendance');
});
Route::middleware(['auth',RoleMiddleware::class . ':coordinator'])->group(function () {
    Route::get('/coordinator/assignments', [AssignmentController::class, 'viewSubmissions'])
        ->name('coordinator.assignments');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/attendance/timeout', [AttendanceController::class, 'timeOut'])->name('attendance.timeout');
});

Route::get('/supervisor/yourstudents', [SupervisorController::class, 'yourStudents'])->name('supervisor.yourstudents');
Route::post('/supervisor/assignStudent', [SupervisorController::class, 'assignStudent'])->name('supervisor.assignStudent');
Route::post('/supervisor/unassignStudent', [SupervisorController::class, 'unassignStudent'])->name('supervisor.unassignStudent');

Route::get('/assignments/{assignment}/edit', [AssignmentController::class, 'edit'])->name('assignments.edit');
Route::put('/assignments/{assignment}', [AssignmentController::class, 'update'])->name('assignments.update');
Route::delete('/assignments/{assignment}', [AssignmentController::class, 'destroy'])->name('assignments.destroy');
Route::get('/supervisor/assignments', [AssignmentController::class, 'index'])->name('supervisor.assignments');
Route::post('/assignments/{id}/autosave', [AssignmentController::class, 'autosave'])->name('assignments.autosave');

Route::patch('/submissions/{submission}/feedback', [SubmissionController::class, 'storeFeedback'])
    ->name('submissions.feedback')->middleware('auth');

Route::middleware(['auth',])->group(function () {
        Route::get('/evaluation', [SubmissionController::class, 'evaluation'])->name('evaluation');
        Route::patch('/submissions/{submission}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
        Route::patch('/submissions/{id}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');

    });

    Route::middleware(['auth',RoleMiddleware::class . ':admin'])->group(function () {
Route::get('/admin/user-management', [AdminController::class, 'userManagement'])->name('admin.userManagement');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
Route::get('/messages/{id}', [MessageController::class, 'show'])->name('messages.show');
});
Route::middleware('auth')->group(function () {
    Route::get('/admin/users', [UserManagementController::class, 'index'])->name('admin.users');
    Route::get('/admin/users/{id}/edit', [UserManagementController::class, 'edit'])->name('admin.users.edit');
    Route::put('/admin/users/{id}', [UserManagementController::class, 'update'])->name('admin.users.update');
    Route::delete('/admin/users/{user}', [UserManagementController::class, 'destroy'])->name('admin.users.destroy');
});

Route::post('/supervisor/profile/setup', [SupervisorProfileController::class, 'store'])->name('supervisor.profile.setup');
Route::get('/redirect-dashboard', [DashboardController::class, 'redirectToDashboard'])->name('redirect.dashboard');



Route::middleware('auth',RoleMiddleware::class . ':admin')->group(function () {
    Route::get('/admin/ojt-configuration', [OjtConfigurationController::class, 'index'])->name('admin.ojt.configuration');
    Route::post('/admin/ojt-configuration', [OjtConfigurationController::class, 'store'])->name('admin.ojt.configuration.store');
});
Route::post('/admin/ojt-config/set-hours', [OjtConfigurationController::class, 'setHours'])->name('admin.ojt-config.set-hours');
Route::get('/admin/ojt-configuration', [OjtConfigurationController::class, 'index'])->name('admin.ojt-configuration');
Route::post('/admin/ojt-configuration', [OjtConfigurationController::class, 'store'])->name('admin.ojt-config.store');
Route::patch('/submissions/{submission}/grade', [SubmissionController::class, 'grade'])->name('submissions.grade');
Route::get('/submissions/{submission}/view', [SubmissionController::class, 'viewSubmission'])->name('submissions.view');
Route::get('/coordinator/student-progress', [CoordinatorController::class, 'studentProgress'])->name('coordinator.student_progress');



Route::middleware(['auth',RoleMiddleware::class . ':coordinator'])->group(function () {
    Route::get('/student-progress', [CoordinatorController::class, 'studentProgress'])->name('coordinator.student_progress');
});

Route::get('/admin/students', [AdminStudentController::class, 'index'])->name('admin.students.index');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('students', AdminStudentController::class);
});

Route::get('/admin/supervisors', [AdminSupervisorController::class, 'index'])->name('admin.supervisors.index');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('supervisors', AdminSupervisorController::class);
});

Route::get('/api/department-stats', function () {
    return StudentProfile::select('department', DB::raw('count(*) as total'))
        ->groupBy('department')
        ->get();
});
Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/messages/{receiver_id}', [ChatController::class, 'fetchMessages']);
    Route::post('/chat/send', [ChatController::class, 'sendMessage']);
});

Route::get('/chat/notifications', [ChatController::class, 'checkNewMessages']);
Route::get('/chat/notifications', [ChatController::class, 'getNotifications']);
Route::post('/chat/markAsRead/{userId}', [ChatController::class, 'markMessagesAsRead']);
Route::post('/chat/mark-as-read/{receiver_id}', [ChatController::class, 'markAsRead']);

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
Route::post('/profile/setup', [ProfileController::class, 'setupProfile'])->name('profile.setup');

});

Route::middleware('auth')->group(function () {
    Route::get('/password-reset', [PasswordController::class, 'showResetForm'])->name('password.reset');
    Route::put('/password-update', [PasswordController::class, 'update'])->name('password.update');
});
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/coordinators', [AdminCoordinatorController::class, 'index'])->name('coordinators.index');
    Route::put('/coordinators/{user_id}', [AdminCoordinatorController::class, 'update'])->name('coordinators.update');
    Route::delete('/coordinators/{user_id}', [AdminCoordinatorController::class, 'destroy'])->name('coordinators.destroy');
});
Route::get('/admin/assignments', [AssignmentController::class, 'index'])->name('admin.assignments');
Route::put('/admin/assignments/{id}', [AssignmentController::class, 'update'])->name('admin.assignments.update');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', UserManagementController::class);
});
});