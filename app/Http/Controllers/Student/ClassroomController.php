<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;

class ClassroomController extends Controller
{
    /**
     * Display listing of student's enrolled classrooms.
     */
    public function index()
    {
        $classrooms = auth()->user()->enrolledClassrooms()
            ->active()
            ->with('teacher')
            ->get();

        return view('student.classrooms.index', compact('classrooms'));
    }

    /**
     * Join a classroom using code.
     */
    public function join(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $classroom = Classroom::where('code', strtoupper($validated['code']))
            ->active()
            ->first();

        if (!$classroom) {
            return back()->with('error', 'Kode kelas tidak ditemukan atau kelas sudah diarsipkan.');
        }

        // Check if already enrolled
        if ($classroom->hasMember(auth()->user())) {
            return back()->with('error', 'Anda sudah terdaftar di kelas ini.');
        }

        // Enroll student
        $classroom->members()->attach(auth()->id(), [
            'role' => 'student',
            'joined_at' => now(),
        ]);

        return redirect()->route('student.classrooms.show', $classroom)
            ->with('success', 'Berhasil bergabung ke kelas: ' . $classroom->name);
    }

    /**
     * Display the classroom.
     */
    public function show(Classroom $classroom)
    {
        // Check if user is member
        if (!$classroom->hasMember(auth()->user())) {
            abort(403, 'Anda tidak terdaftar di kelas ini.');
        }

        $classroom->load(['teacher', 'materials' => fn($q) => $q->published()->ordered(), 'announcements' => fn($q) => $q->pinnedFirst()->take(5)]);

        $assignments = $classroom->assignments()
            ->published()
            ->latest()
            ->get()
            ->map(function ($assignment) {
                $assignment->submission = $assignment->getSubmission(auth()->user());
                return $assignment;
            });

        return view('student.classrooms.show', compact('classroom', 'assignments'));
    }

    /**
     * Leave the classroom.
     */
    public function leave(Classroom $classroom)
    {
        if (!$classroom->hasMember(auth()->user())) {
            abort(403);
        }

        $classroom->members()->detach(auth()->id());

        return redirect()->route('student.classrooms.index')
            ->with('success', 'Anda telah keluar dari kelas: ' . $classroom->name);
    }
}
