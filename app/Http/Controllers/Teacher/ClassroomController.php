<?php

namespace App\Http\Controllers\Teacher;

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

        return view('teacher.classrooms.index', compact('classrooms'));
    }

    /**
     * Show the form for creating a new classroom.
     */
    public function create()
    {
        return view('teacher.classrooms.create');
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

        return redirect()->route('teacher.classrooms.show', $classroom)
            ->with('success', 'Kelas berhasil dibuat dengan kode: ' . $classroom->code);
    }

    /**
     * Display the specified classroom.
     */
    public function show(Classroom $classroom)
    {
        $this->authorize('view', $classroom);

        $classroom->load(['students', 'materials' => fn($q) => $q->ordered(), 'announcements' => fn($q) => $q->pinnedFirst()->take(5)]);

        $assignments = $classroom->assignments()
            ->published()
            ->latest()
            ->take(5)
            ->get();

        return view('teacher.classrooms.show', compact('classroom', 'assignments'));
    }

    /**
     * Show the form for editing the classroom.
     */
    public function edit(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        return view('teacher.classrooms.edit', compact('classroom'));
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

        return redirect()->route('teacher.classrooms.show', $classroom)
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Display classroom members.
     */
    public function members(Classroom $classroom)
    {
        $this->authorize('view', $classroom);

        $members = $classroom->members()->get();

        return view('teacher.classrooms.members', compact('classroom', 'members'));
    }

    /**
     * Remove a member from classroom.
     */
    public function removeMember(Classroom $classroom, $userId)
    {
        $this->authorize('update', $classroom);

        $classroom->members()->detach($userId);

        return back()->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }

    /**
     * Archive the classroom.
     */
    public function archive(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $classroom->update(['status' => 'archived']);

        return redirect()->route('teacher.classrooms.index')
            ->with('success', 'Kelas berhasil diarsipkan.');
    }
}
