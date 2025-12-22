<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display all students across teacher's classrooms.
     */
    public function index()
    {
        $user = auth()->user();
        $classrooms = $user->teachingClassrooms()->with('students')->get();

        // Get all unique students
        $studentIds = collect();
        foreach ($classrooms as $classroom) {
            $studentIds = $studentIds->merge($classroom->students->pluck('id'));
        }
        $studentIds = $studentIds->unique();

        $students = User::whereIn('id', $studentIds)
            ->with([
                'enrolledClassrooms' => function ($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                }
            ])
            ->get();

        return view('teacher.students.index', compact('students', 'classrooms'));
    }
}
