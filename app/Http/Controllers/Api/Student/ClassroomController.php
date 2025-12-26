<?php

namespace App\Http\Controllers\Api\Student;

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

        return response()->json($classrooms);
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
            return response()->json(['message' => 'Kode kelas tidak ditemukan atau terkunci.'], 404);
        }

        // Check if already enrolled
        if ($classroom->hasMember(auth()->user())) {
            return response()->json(['message' => 'Anda sudah terdaftar di kelas ini.'], 422);
        }

        // Enroll student
        $classroom->members()->attach(auth()->id(), [
            'role' => 'student',
            'joined_at' => now(),
        ]);

        return response()->json([
            'message' => 'Berhasil bergabung ke kelas.',
            'classroom' => $classroom
        ]);
    }

    /**
     * Display the specified classroom.
     */
    public function show(Classroom $classroom)
    {
        // Check if user is member
        if (!$classroom->hasMember(auth()->user())) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke kelas ini.'], 403);
        }

        $classroom->load(['teacher', 'materials' => fn($q) => $q->published()->ordered(), 'announcements' => fn($q) => $q->pinnedFirst()->take(5)]);

        $assignments = $classroom->assignments()
            ->published()
            ->latest()
            ->get()
            ->map(function ($assignment) {
                // Attach submission status if needed, simplified for API list
                $assignment->submission = $assignment->getSubmission(auth()->user());
                return $assignment;
            });

        return response()->json([
            'classroom' => $classroom,
            'assignments' => $assignments
        ]);
    }

    /**
     * Leave the classroom.
     */
    public function leave(Classroom $classroom)
    {
        if (!$classroom->hasMember(auth()->user())) {
            return response()->json(['message' => 'Anda tidak memiliki akses ke kelas ini.'], 403);
        }

        $classroom->members()->detach(auth()->id());

        return response()->json(['message' => 'Berhasil keluar dari kelas.']);
    }
}
