<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\Classroom;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

        $exams = $classroom->exams()
            ->with([
                'attempts' => function ($query) {
                    $query->with('user');
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
                'exams' => [],
                'average' => 0,
            ];

            $totalScore = 0;
            $gradedCount = 0;

            // Process Assignments
            foreach ($assignments as $assignment) {
                $submission = $assignment->submissions->firstWhere('student_id', $student->id);
                $grades[$student->id]['assignments'][$assignment->id] = $submission;

                if ($submission && $submission->status === 'graded') {
                    $totalScore += ($submission->score / $assignment->max_score) * 100;
                    $gradedCount++;
                }
            }

            // Process Exams
            foreach ($exams as $exam) {
                $attempt = $exam->attempts->firstWhere('user_id', $student->id);
                $grades[$student->id]['exams'][$exam->id] = $attempt;

                if ($attempt && $attempt->score !== null) {
                    // Exam score is already 0-100 based on our previous logic
                    $totalScore += $attempt->score;
                    $gradedCount++;
                }
            }

            $grades[$student->id]['average'] = $gradedCount > 0 ? round($totalScore / $gradedCount, 1) : null;
        }

        return view('teacher.reports.classroom', compact('classroom', 'assignments', 'exams', 'students', 'grades'));
    }

    /**
     * Export classroom grades to CSV.
     */
    public function export(Classroom $classroom)
    {
        $this->authorize('view', $classroom);

        $assignments = $classroom->assignments()
            ->with([
                'submissions' => function ($query) {
                    $query->with('student');
                }
            ])
            ->orderBy('created_at')
            ->get();

        $exams = $classroom->exams()
            ->with([
                'attempts' => function ($query) {
                    $query->with('user');
                }
            ])
            ->orderBy('created_at')
            ->get();

        $students = $classroom->students()->orderBy('name')->get();

        // Build CSV content
        $filename = 'rekap_nilai_' . str_replace(' ', '_', $classroom->name) . '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($classroom, $assignments, $exams, $students) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Title row
            fputcsv($file, ['REKAP NILAI SISWA']);
            fputcsv($file, ['Kelas: ' . $classroom->name]);
            fputcsv($file, ['Mata Pelajaran: ' . ($classroom->subject ?? '-')]);
            fputcsv($file, ['Tanggal Export: ' . date('d/m/Y H:i')]);
            fputcsv($file, []); // Empty row

            // Header row
            $headerRow = ['No', 'Nama Siswa', 'Email'];
            foreach ($assignments as $assignment) {
                $headerRow[] = $assignment->title . ' (Max: ' . $assignment->max_score . ')';
            }
            foreach ($exams as $exam) {
                $headerRow[] = '[Ujian] ' . $exam->title;
            }
            $headerRow[] = 'Rata-rata (%)';
            fputcsv($file, $headerRow);

            // Data rows
            $no = 1;
            foreach ($students as $student) {
                $row = [$no++, $student->name, $student->email];

                $totalScore = 0;
                $gradedCount = 0;

                foreach ($assignments as $assignment) {
                    $submission = $assignment->submissions->firstWhere('student_id', $student->id);

                    if ($submission && $submission->status === 'graded') {
                        $row[] = $submission->score;
                        $totalScore += ($submission->score / $assignment->max_score) * 100;
                        $gradedCount++;
                    } elseif ($submission) {
                        $row[] = 'Menunggu';
                    } else {
                        $row[] = '-';
                    }
                }

                foreach ($exams as $exam) {
                    $attempt = $exam->attempts->firstWhere('user_id', $student->id);
                    if ($attempt && $attempt->score !== null) {
                        $row[] = $attempt->score;
                        $totalScore += $attempt->score;
                        $gradedCount++;
                    } else {
                        $row[] = '-';
                    }
                }

                // Average
                $average = $gradedCount > 0 ? round($totalScore / $gradedCount, 1) : '-';
                $row[] = $average;

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
