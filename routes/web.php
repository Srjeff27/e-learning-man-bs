<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\AssignmentController as StudentAssignmentController;
use App\Http\Controllers\Student\ClassroomController as StudentClassroomController;
use App\Http\Controllers\Teacher\AssignmentController as TeacherAssignmentController;
use App\Http\Controllers\Teacher\ClassroomController as TeacherClassroomController;
use App\Http\Controllers\Teacher\MaterialController as TeacherMaterialController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (Guest)
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/profil', [HomeController::class, 'profil'])->name('profil');
Route::get('/visi-misi', [HomeController::class, 'visiMisi'])->name('visi-misi');
Route::get('/struktur-organisasi', [HomeController::class, 'strukturOrganisasi'])->name('struktur-organisasi');
Route::get('/guru-staff', [HomeController::class, 'guruStaff'])->name('guru-staff');
Route::get('/berita', [HomeController::class, 'berita'])->name('berita');
Route::get('/berita/{slug}', [HomeController::class, 'beritaShow'])->name('berita.show');
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
Route::get('/kalender/download', [HomeController::class, 'downloadCalendar'])->name('kalender.download');
Route::get('/kalender', [HomeController::class, 'kalender'])->name('kalender');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::post('/kontak', [HomeController::class, 'kontakSubmit'])->name('kontak.submit');

/*
|--------------------------------------------------------------------------
| Chatbot Routes (Public)
|--------------------------------------------------------------------------
*/

Route::prefix('chatbot')->name('chatbot.')->group(function () {
    Route::get('/', [ChatbotController::class, 'index'])->name('index');
    Route::post('/session', [ChatbotController::class, 'session'])->name('session');
    Route::post('/send', [ChatbotController::class, 'send'])->name('send');
    Route::post('/clear', [ChatbotController::class, 'clear'])->name('clear');
});

/*
|--------------------------------------------------------------------------
| Dashboard Routes (Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();

        // Redirect based on role
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }
        if ($user->isGuru()) {
            return redirect()->route('teacher.classrooms.index');
        }
        if ($user->isSiswa()) {
            return redirect()->route('student.classrooms.index');
        }

        return view('dashboard');
    })->name('dashboard');

    Route::get('/home', function () {
        return redirect()->route('dashboard');
    });

    // Account Settings Routes (for all authenticated users)
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/settings', [\App\Http\Controllers\AccountSettingsController::class, 'index'])->name('settings');
        Route::put('/profile', [\App\Http\Controllers\AccountSettingsController::class, 'updateProfile'])->name('update-profile');
        Route::put('/avatar', [\App\Http\Controllers\AccountSettingsController::class, 'updateAvatar'])->name('update-avatar');
        Route::delete('/avatar', [\App\Http\Controllers\AccountSettingsController::class, 'removeAvatar'])->name('remove-avatar');
        Route::put('/password', [\App\Http\Controllers\AccountSettingsController::class, 'updatePassword'])->name('update-password');
    });
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Users Management
    Route::resource('users', UserController::class);
    Route::patch('users/{user}/toggle-active', [UserController::class, 'toggleActive'])->name('users.toggle-active');

    // Banner Management
    Route::resource('banners', \App\Http\Controllers\Admin\BannerController::class);

    // Profile Management
    Route::get('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('profile.index');
    Route::put('profile', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('profile.update');

    // News Management
    Route::resource('news', \App\Http\Controllers\Admin\NewsController::class);
    Route::patch('news/{news}/toggle', [\App\Http\Controllers\Admin\NewsController::class, 'toggle'])->name('news.toggle');

    // Gallery Management
    Route::resource('gallery', \App\Http\Controllers\Admin\GalleryController::class);

    // Calendar/Events Management
    Route::resource('calendar', \App\Http\Controllers\Admin\CalendarController::class);

    // Contact Messages Management
    Route::get('contacts', [\App\Http\Controllers\Admin\ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'show'])->name('contacts.show');
    Route::patch('contacts/{contact}/read', [\App\Http\Controllers\Admin\ContactController::class, 'markAsRead'])->name('contacts.mark-read');
    Route::delete('contacts/{contact}', [\App\Http\Controllers\Admin\ContactController::class, 'destroy'])->name('contacts.destroy');

    // Teachers Management
    Route::resource('teachers', \App\Http\Controllers\Admin\TeacherController::class)->except(['show']);
    Route::patch('teachers/{teacher}/toggle-active', [\App\Http\Controllers\Admin\TeacherController::class, 'toggleActive'])->name('teachers.toggle-active');
});

/*
|--------------------------------------------------------------------------
| Teacher Routes (LMS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:guru,admin'])->prefix('teacher')->name('teacher.')->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Teacher\DashboardController::class, 'index'])->name('dashboard');

    // Students Management
    Route::get('students', [\App\Http\Controllers\Teacher\StudentController::class, 'index'])->name('students.index');

    // Reports
    Route::get('reports', [\App\Http\Controllers\Teacher\ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/classroom/{classroom}', [\App\Http\Controllers\Teacher\ReportController::class, 'classroom'])->name('reports.classroom');
    Route::get('reports/export/{classroom}', [\App\Http\Controllers\Teacher\ReportController::class, 'export'])->name('reports.export');

    // Classrooms
    Route::get('classrooms', [TeacherClassroomController::class, 'index'])->name('classrooms.index');
    Route::get('classrooms/create', [TeacherClassroomController::class, 'create'])->name('classrooms.create');
    Route::post('classrooms', [TeacherClassroomController::class, 'store'])->name('classrooms.store');
    Route::get('classrooms/{classroom}', [TeacherClassroomController::class, 'show'])->name('classrooms.show');
    Route::get('classrooms/{classroom}/edit', [TeacherClassroomController::class, 'edit'])->name('classrooms.edit');
    Route::put('classrooms/{classroom}', [TeacherClassroomController::class, 'update'])->name('classrooms.update');
    Route::get('classrooms/{classroom}/members', [TeacherClassroomController::class, 'members'])->name('classrooms.members');
    Route::delete('classrooms/{classroom}/members/{user}', [TeacherClassroomController::class, 'removeMember'])->name('classrooms.remove-member');
    Route::post('classrooms/{classroom}/archive', [TeacherClassroomController::class, 'archive'])->name('classrooms.archive');
    Route::delete('classrooms/{classroom}', [TeacherClassroomController::class, 'destroy'])->name('classrooms.destroy');

    // Materials
    Route::get('classrooms/{classroom}/materials/create', [TeacherMaterialController::class, 'create'])->name('materials.create');
    Route::post('classrooms/{classroom}/materials', [TeacherMaterialController::class, 'store'])->name('materials.store');
    Route::get('classrooms/{classroom}/materials/{material}', [TeacherMaterialController::class, 'show'])->name('materials.show');
    Route::get('classrooms/{classroom}/materials/{material}/edit', [TeacherMaterialController::class, 'edit'])->name('materials.edit');
    Route::put('classrooms/{classroom}/materials/{material}', [TeacherMaterialController::class, 'update'])->name('materials.update');
    Route::delete('classrooms/{classroom}/materials/{material}', [TeacherMaterialController::class, 'destroy'])->name('materials.destroy');

    // Assignments
    Route::get('classrooms/{classroom}/assignments/create', [TeacherAssignmentController::class, 'create'])->name('assignments.create');
    Route::post('classrooms/{classroom}/assignments', [TeacherAssignmentController::class, 'store'])->name('assignments.store');
    Route::get('classrooms/{classroom}/assignments/{assignment}', [TeacherAssignmentController::class, 'show'])->name('assignments.show');
    Route::get('classrooms/{classroom}/assignments/{assignment}/edit', [TeacherAssignmentController::class, 'edit'])->name('assignments.edit');
    Route::put('classrooms/{classroom}/assignments/{assignment}', [TeacherAssignmentController::class, 'update'])->name('assignments.update');
    Route::delete('classrooms/{classroom}/assignments/{assignment}', [TeacherAssignmentController::class, 'destroy'])->name('assignments.destroy');
    Route::post('classrooms/{classroom}/assignments/{assignment}/submissions/{submission}/grade', [TeacherAssignmentController::class, 'grade'])->name('assignments.grade');

    // Schedules
    Route::get('classrooms/{classroom}/schedules', [\App\Http\Controllers\Teacher\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('classrooms/{classroom}/schedules/create', [\App\Http\Controllers\Teacher\ScheduleController::class, 'create'])->name('schedules.create');
    Route::post('classrooms/{classroom}/schedules', [\App\Http\Controllers\Teacher\ScheduleController::class, 'store'])->name('schedules.store');
    Route::get('classrooms/{classroom}/schedules/{schedule}/edit', [\App\Http\Controllers\Teacher\ScheduleController::class, 'edit'])->name('schedules.edit');
    Route::put('classrooms/{classroom}/schedules/{schedule}', [\App\Http\Controllers\Teacher\ScheduleController::class, 'update'])->name('schedules.update');
    Route::delete('classrooms/{classroom}/schedules/{schedule}', [\App\Http\Controllers\Teacher\ScheduleController::class, 'destroy'])->name('schedules.destroy');

    // Attendance
    Route::get('attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'classrooms'])->name('attendance.classrooms');
    Route::get('classrooms/{classroom}/attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('classrooms/{classroom}/attendance/create', [\App\Http\Controllers\Teacher\AttendanceController::class, 'create'])->name('attendance.create');
    Route::post('classrooms/{classroom}/attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'storeSession'])->name('attendance.store-session');
    Route::get('classrooms/{classroom}/attendance/{session}/take', [\App\Http\Controllers\Teacher\AttendanceController::class, 'take'])->name('attendance.take');
    Route::post('classrooms/{classroom}/attendance/{session}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('classrooms/{classroom}/attendance/{session}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'show'])->name('attendance.show');
    Route::delete('classrooms/{classroom}/attendance/{session}', [\App\Http\Controllers\Teacher\AttendanceController::class, 'destroySession'])->name('attendance.destroy');
    Route::get('classrooms/{classroom}/attendance-report', [\App\Http\Controllers\Teacher\AttendanceController::class, 'report'])->name('attendance.report');
    Route::get('classrooms/{classroom}/attendance-export', [\App\Http\Controllers\Teacher\AttendanceController::class, 'exportReport'])->name('attendance.export');
});

/*
|--------------------------------------------------------------------------
| Student Routes (LMS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:siswa'])->prefix('student')->name('student.')->group(function () {
    // Dashboard
    Route::get('/', [\App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');

    // Classrooms
    Route::get('classrooms', [StudentClassroomController::class, 'index'])->name('classrooms.index');
    Route::post('classrooms/join', [StudentClassroomController::class, 'join'])->name('classrooms.join');
    Route::get('classrooms/{classroom}', [StudentClassroomController::class, 'show'])->name('classrooms.show');
    Route::post('classrooms/{classroom}/leave', [StudentClassroomController::class, 'leave'])->name('classrooms.leave');

    // All Assignments (across all classrooms)
    Route::get('assignments', [\App\Http\Controllers\Student\AssignmentController::class, 'index'])->name('assignments.index');

    // Assignments (within classroom)
    Route::get('classrooms/{classroom}/assignments/{assignment}', [StudentAssignmentController::class, 'show'])->name('assignments.show');
    Route::post('classrooms/{classroom}/assignments/{assignment}/submit', [StudentAssignmentController::class, 'submit'])->name('assignments.submit');
    Route::get('classrooms/{classroom}/assignments/{assignment}/result', [StudentAssignmentController::class, 'result'])->name('assignments.result');
});

/*
|--------------------------------------------------------------------------
| Notification Routes (Authenticated)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [\App\Http\Controllers\NotificationController::class, 'index'])->name('index');
    Route::get('/recent', [\App\Http\Controllers\NotificationController::class, 'recent'])->name('recent');
    Route::get('/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('unread-count');
    Route::post('/{notification}/read', [\App\Http\Controllers\NotificationController::class, 'markAsRead'])->name('read');
    Route::post('/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
    Route::delete('/{notification}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('destroy');
});

