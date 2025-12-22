<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Submission;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display grade reports overview.
     */
    public function index()
    {
        $user = auth()->user();
        $classrooms = $user->teachingClassrooms()
            ->withCount(['students', 'assignments'])
            ->get();

        return view('teacher.reports.index', compact('classrooms'));
    }

    /**
     * Display detailed report for a classroom.
     */
    public function classroom(Classroom $classroom)
    {
        $this->authorize('view', $classroom);

        $assignments = $classroom->assignments()
            ->with([
                'submissions' => function ($query) {
                    $query->with('student');
                }
            ])
            ->get();

        $students = $classroom->students;

        // Build grade matrix
        $grades = [];
        foreach ($students as $student) {
            $grades[$student->id] = [
                'student' => $student,
                'assignments' => [],
                'average' => 0,
            ];

            $totalScore = 0;
            $gradedCount = 0;

            foreach ($assignments as $assignment) {
                $submission = $assignment->submissions->firstWhere('student_id', $student->id);
                $grades[$student->id]['assignments'][$assignment->id] = $submission;

                if ($submission && $submission->status === 'graded') {
                    $totalScore += ($submission->score / $assignment->max_score) * 100;
                    $gradedCount++;
                }
            }

            $grades[$student->id]['average'] = $gradedCount > 0 ? round($totalScore / $gradedCount, 1) : null;
        }

        return view('teacher.reports.classroom', compact('classroom', 'assignments', 'students', 'grades'));
    }

    /**
     * Export classroom grades.
     */
    public function export(Classroom $classroom)
    {
        $this->authorize('view', $classroom);

        // For now, redirect back with message
        return back()->with('success', 'Fitur export sedang dalam pengembangan.');
    }
}
