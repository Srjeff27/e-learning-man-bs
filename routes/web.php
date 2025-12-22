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
Route::get('/galeri', [HomeController::class, 'galeri'])->name('galeri');
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
    Route::resource('banners', BannerController::class)->except(['show']);
    Route::patch('banners/{banner}/toggle', [BannerController::class, 'toggle'])->name('banners.toggle');
});

/*
|--------------------------------------------------------------------------
| Teacher Routes (LMS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:guru,admin'])->prefix('teacher')->name('teacher.')->group(function () {
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
    Route::get('classrooms/{classroom}/attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('classrooms/{classroom}/attendance', [\App\Http\Controllers\Teacher\AttendanceController::class, 'store'])->name('attendance.store');
    Route::get('classrooms/{classroom}/attendance/report', [\App\Http\Controllers\Teacher\AttendanceController::class, 'report'])->name('attendance.report');
});

/*
|--------------------------------------------------------------------------
| Student Routes (LMS)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:siswa'])->prefix('student')->name('student.')->group(function () {
    // Classrooms
    Route::get('classrooms', [StudentClassroomController::class, 'index'])->name('classrooms.index');
    Route::post('classrooms/join', [StudentClassroomController::class, 'join'])->name('classrooms.join');
    Route::get('classrooms/{classroom}', [StudentClassroomController::class, 'show'])->name('classrooms.show');
    Route::post('classrooms/{classroom}/leave', [StudentClassroomController::class, 'leave'])->name('classrooms.leave');

    // Assignments
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

