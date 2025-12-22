<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Classroom;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the teacher dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Get teacher's classrooms
        $classrooms = $user->teachingClassrooms()
            ->withCount('students')
            ->get();

        // Get total students across all classrooms
        $totalStudents = $classrooms->sum('students_count');

        // Get pending submissions (not graded yet)
        $pendingSubmissions = \App\Models\Submission::whereHas('assignment', function ($query) use ($classrooms) {
            $query->whereIn('classroom_id', $classrooms->pluck('id'));
        })
            ->where('status', 'submitted')
            ->count();

        // Get recent assignments
        $recentAssignments = Assignment::whereIn('classroom_id', $classrooms->pluck('id'))
            ->with('classroom')
            ->latest()
            ->take(5)
            ->get();

        // Get recent submissions to grade
        $recentSubmissions = \App\Models\Submission::whereHas('assignment', function ($query) use ($classrooms) {
            $query->whereIn('classroom_id', $classrooms->pluck('id'));
        })
            ->where('status', 'submitted')
            ->with(['student', 'assignment.classroom'])
            ->latest('submitted_at')
            ->take(5)
            ->get();

        // Stats
        $stats = [
            'classrooms' => $classrooms->count(),
            'students' => $totalStudents,
            'assignments' => Assignment::whereIn('classroom_id', $classrooms->pluck('id'))->count(),
            'pending_submissions' => $pendingSubmissions,
        ];

        return view('teacher.dashboard', compact('classrooms', 'recentAssignments', 'recentSubmissions', 'stats'));
    }
}
