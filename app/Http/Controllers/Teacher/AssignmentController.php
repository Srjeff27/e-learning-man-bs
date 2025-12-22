<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Submission;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Show the form for creating a new assignment.
     */
    public function create(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        return view('teacher.assignments.create', compact('classroom'));
    }

    /**
     * Store a newly created assignment.
     */
    public function store(Request $request, Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'max_score' => 'required|integer|min:1|max:100',
            'due_date' => 'nullable|date|after:now',
            'allow_late_submission' => 'boolean',
            'late_penalty_percent' => 'nullable|integer|min:0|max:100',
            'submission_type' => 'required|in:file,text,link,multiple',
            'is_published' => 'boolean',
        ]);

        $validated['classroom_id'] = $classroom->id;
        $validated['created_by'] = auth()->id();
        $validated['allow_late_submission'] = $request->boolean('allow_late_submission');
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published']) {
            $validated['published_at'] = now();
        }

        Assignment::create($validated);

        return redirect()->route('teacher.classrooms.show', $classroom)
            ->with('success', 'Tugas berhasil dibuat.');
    }

    /**
     * Display the assignment with submissions.
     */
    public function show(Classroom $classroom, Assignment $assignment)
    {
        $this->authorize('view', $classroom);

        $submissions = $assignment->submissions()
            ->with('student')
            ->get();

        $students = $classroom->students;
        $submittedIds = $submissions->pluck('student_id');
        $notSubmitted = $students->whereNotIn('id', $submittedIds);

        return view('teacher.assignments.show', compact('classroom', 'assignment', 'submissions', 'notSubmitted'));
    }

    /**
     * Show the form for editing an assignment.
     */
    public function edit(Classroom $classroom, Assignment $assignment)
    {
        $this->authorize('update', $classroom);

        return view('teacher.assignments.edit', compact('classroom', 'assignment'));
    }

    /**
     * Update the assignment.
     */
    public function update(Request $request, Classroom $classroom, Assignment $assignment)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'instructions' => 'nullable|string',
            'max_score' => 'required|integer|min:1|max:100',
            'due_date' => 'nullable|date',
            'allow_late_submission' => 'boolean',
            'late_penalty_percent' => 'nullable|integer|min:0|max:100',
            'submission_type' => 'required|in:file,text,link,multiple',
            'is_published' => 'boolean',
        ]);

        $validated['allow_late_submission'] = $request->boolean('allow_late_submission');
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['is_published'] && !$assignment->published_at) {
            $validated['published_at'] = now();
        }

        $assignment->update($validated);

        return redirect()->route('teacher.assignments.show', [$classroom, $assignment])
            ->with('success', 'Tugas berhasil diperbarui.');
    }

    /**
     * Grade a submission.
     */
    public function grade(Request $request, Classroom $classroom, Assignment $assignment, Submission $submission)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'score' => 'required|integer|min:0|max:' . $assignment->max_score,
            'feedback' => 'nullable|string|max:2000',
        ]);

        $submission->grade($validated['score'], $validated['feedback'], auth()->user());

        return back()->with('success', 'Nilai berhasil disimpan.');
    }

    /**
     * Delete an assignment.
     */
    public function destroy(Classroom $classroom, Assignment $assignment)
    {
        $this->authorize('update', $classroom);

        $assignment->delete();

        return redirect()->route('teacher.classrooms.show', $classroom)
            ->with('success', 'Tugas berhasil dihapus.');
    }
}
