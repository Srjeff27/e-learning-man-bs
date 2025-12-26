<?php

namespace App\Http\Controllers\Api\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClassroomController extends Controller
{
    /**
     * Display listing of teacher's classrooms.
     */
    public function index()
    {
        $classrooms = auth()->user()->teachingClassrooms()
            ->withCount('students')
            ->latest()
            ->get();

        return response()->json($classrooms);
    }

    /**
     * Store a newly created classroom.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'subject' => 'nullable|string|max:100',
            'grade' => 'nullable|string|max:50',
            'academic_year' => 'nullable|string|max:20',
            'semester' => 'nullable|string|max:20',
        ]);

        $validated['teacher_id'] = auth()->id();
        $validated['code'] = strtoupper(Str::random(6));

        $classroom = Classroom::create($validated);

        return response()->json([
            'message' => 'Kelas berhasil dibuat.',
            'classroom' => $classroom,
        ], 201);
    }

    /**
     * Display the specified classroom.
     */
    public function show(Classroom $classroom)
    {
        $this->authorize('view', $classroom);

        $classroom->load(['students', 'materials' => fn($q) => $q->ordered(), 'announcements' => fn($q) => $q->pinnedFirst()->take(5)]);

        // Include assignments summary
        $assignments = $classroom->assignments()
            ->published()
            ->latest()
            ->take(5)
            ->get();

        return response()->json([
            'classroom' => $classroom,
            'recent_assignments' => $assignments
        ]);
    }

    /**
     * Update the specified classroom.
     */
    public function update(Request $request, Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'subject' => 'nullable|string|max:100',
            'grade' => 'nullable|string|max:50',
            'academic_year' => 'nullable|string|max:20',
            'semester' => 'nullable|string|max:20',
            'status' => 'in:active,archived',
        ]);

        $classroom->update($validated);

        return response()->json([
            'message' => 'Kelas berhasil diperbarui.',
            'classroom' => $classroom
        ]);
    }

    /**
     * Delete the classroom.
     */
    public function destroy(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $classroom->delete();

        return response()->json(['message' => 'Kelas berhasil dihapus.']);
    }
}
