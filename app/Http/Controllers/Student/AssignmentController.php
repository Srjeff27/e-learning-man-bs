<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AssignmentController extends Controller
{
    /**
     * Display the assignment.
     */
    public function show(Classroom $classroom, Assignment $assignment)
    {
        if (!$classroom->hasMember(auth()->user())) {
            abort(403);
        }

        $submission = $assignment->getSubmission(auth()->user());

        return view('student.assignments.show', compact('classroom', 'assignment', 'submission'));
    }

    /**
     * Submit the assignment.
     */
    public function submit(Request $request, Classroom $classroom, Assignment $assignment)
    {
        if (!$classroom->hasMember(auth()->user())) {
            abort(403);
        }

        // Check if already submitted
        $submission = $assignment->getSubmission(auth()->user());

        if ($submission && $submission->status !== 'draft') {
            return back()->with('error', 'Tugas sudah dikumpulkan sebelumnya.');
        }

        // Validate based on submission type
        $rules = [];
        if ($assignment->submission_type === 'text') {
            $rules['content'] = 'required|string|max:10000';
        } elseif ($assignment->submission_type === 'file') {
            $rules['file'] = 'required|file|max:10240';
        } elseif ($assignment->submission_type === 'link') {
            $rules['external_link'] = 'required|url';
        } else {
            $rules['content'] = 'nullable|string|max:10000';
            $rules['file'] = 'nullable|file|max:10240';
            $rules['external_link'] = 'nullable|url';
        }

        $validated = $request->validate($rules);

        // Create or update submission
        if (!$submission) {
            $submission = new Submission([
                'assignment_id' => $assignment->id,
                'student_id' => auth()->id(),
            ]);
        }

        $submission->content = $validated['content'] ?? null;
        $submission->external_link = $validated['external_link'] ?? null;

        // Handle file upload
        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($submission->file_path) {
                Storage::disk('public')->delete($submission->file_path);
            }

            $file = $request->file('file');
            $path = $file->store('submissions/' . $assignment->id, 'public');
            $submission->file_path = $path;
            $submission->file_name = $file->getClientOriginalName();
        }

        $submission->save();
        $submission->submit();

        return redirect()->route('student.assignments.show', [$classroom, $assignment])
            ->with('success', 'Tugas berhasil dikumpulkan.');
    }

    /**
     * View submission result/grade.
     */
    public function result(Classroom $classroom, Assignment $assignment)
    {
        if (!$classroom->hasMember(auth()->user())) {
            abort(403);
        }

        $submission = $assignment->getSubmission(auth()->user());

        if (!$submission) {
            return redirect()->route('student.assignments.show', [$classroom, $assignment])
                ->with('error', 'Anda belum mengumpulkan tugas ini.');
        }

        return view('student.assignments.result', compact('classroom', 'assignment', 'submission'));
    }
}
