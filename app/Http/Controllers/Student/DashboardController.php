<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the student dashboard.
     */
    public function index()
    {
        $user = auth()->user();

        // Get enrolled classrooms
        $classrooms = $user->enrolledClassrooms()->with('teacher')->get();

        // Get upcoming assignments
        $upcomingAssignments = Assignment::whereIn('classroom_id', $classrooms->pluck('id'))
            ->where('is_published', true)
            ->where(function ($query) {
                $query->where('due_date', '>', now())
                    ->orWhereNull('due_date');
            })
            ->orderBy('due_date')
            ->take(5)
            ->get();

        // Get recent materials
        $recentMaterials = \App\Models\Material::whereIn('classroom_id', $classrooms->pluck('id'))
            ->where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Stats
        $stats = [
            'classrooms' => $classrooms->count(),
            'assignments_pending' => Assignment::whereIn('classroom_id', $classrooms->pluck('id'))
                ->where('is_published', true)
                ->whereDoesntHave('submissions', function ($query) use ($user) {
                    $query->where('student_id', $user->id);
                })
                ->count(),
            'assignments_completed' => Assignment::whereIn('classroom_id', $classrooms->pluck('id'))
                ->whereHas('submissions', function ($query) use ($user) {
                    $query->where('student_id', $user->id);
                })
                ->count(),
        ];

        return view('student.dashboard', compact('classrooms', 'upcomingAssignments', 'recentMaterials', 'stats'));
    }
}
