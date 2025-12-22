<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Show attendance page for a classroom.
     */
    public function index(Classroom $classroom, Request $request)
    {
        $this->authorize('update', $classroom);

        $date = $request->input('date', now()->format('Y-m-d'));

        $students = $classroom->students()->orderBy('name')->get();

        $attendances = Attendance::where('classroom_id', $classroom->id)
            ->forDate($date)
            ->get()
            ->keyBy('student_id');

        return view('teacher.attendance.index', compact('classroom', 'students', 'attendances', 'date'));
    }

    /**
     * Store or update attendance for a date.
     */
    public function store(Classroom $classroom, Request $request)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'date' => 'required|date',
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:hadir,izin,sakit,alpha',
            'attendance.*.notes' => 'nullable|string|max:255',
        ]);

        foreach ($validated['attendance'] as $studentId => $data) {
            Attendance::updateOrCreate(
                [
                    'classroom_id' => $classroom->id,
                    'student_id' => $studentId,
                    'date' => $validated['date'],
                ],
                [
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                    'recorded_by' => auth()->id(),
                ]
            );
        }

        return redirect()
            ->route('teacher.attendance.index', ['classroom' => $classroom, 'date' => $validated['date']])
            ->with('success', 'Absensi berhasil disimpan.');
    }

    /**
     * Show attendance report for a classroom.
     */
    public function report(Classroom $classroom, Request $request)
    {
        $this->authorize('view', $classroom);

        $startDate = $request->input('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', now()->format('Y-m-d'));

        $students = $classroom->students()->orderBy('name')->get();

        $attendances = Attendance::where('classroom_id', $classroom->id)
            ->dateRange($startDate, $endDate)
            ->get()
            ->groupBy('student_id');

        // Calculate summary for each student
        $summary = [];
        foreach ($students as $student) {
            $studentAttendances = $attendances->get($student->id, collect());
            $summary[$student->id] = [
                'hadir' => $studentAttendances->where('status', 'hadir')->count(),
                'izin' => $studentAttendances->where('status', 'izin')->count(),
                'sakit' => $studentAttendances->where('status', 'sakit')->count(),
                'alpha' => $studentAttendances->where('status', 'alpha')->count(),
                'total' => $studentAttendances->count(),
            ];
        }

        return view('teacher.attendance.report', compact('classroom', 'students', 'summary', 'startDate', 'endDate'));
    }
}
