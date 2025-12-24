<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttendanceSession;
use App\Models\Classroom;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    /**
     * Show list of all classrooms for attendance.
     */
    public function classrooms()
    {
        $classrooms = auth()->user()->teachingClassrooms()
            ->withCount(['students', 'attendanceSessions'])
            ->where('status', 'active')
            ->latest()
            ->get();

        return view('teacher.attendance.classrooms', compact('classrooms'));
    }

    /**
     * Show attendance sessions for a classroom.
     */
    public function index(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $sessions = $classroom->attendanceSessions()
            ->with('creator')
            ->withCount('attendances')
            ->latest('date')
            ->paginate(10);

        return view('teacher.attendance.index', compact('classroom', 'sessions'));
    }

    /**
     * Show form to create a new attendance session.
     */
    public function create(Classroom $classroom)
    {
        $this->authorize('update', $classroom);

        $nextSessionNumber = $classroom->attendanceSessions()->max('session_number') + 1;

        return view('teacher.attendance.create', compact('classroom', 'nextSessionNumber'));
    }

    /**
     * Store a new attendance session.
     */
    public function storeSession(Classroom $classroom, Request $request)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'session_number' => 'required|integer|min:1',
            'topic' => 'required|string|max:255',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $validated['classroom_id'] = $classroom->id;
        $validated['created_by'] = auth()->id();

        $session = AttendanceSession::create($validated);

        return redirect()
            ->route('teacher.attendance.take', [$classroom, $session])
            ->with('success', 'Sesi pertemuan berhasil dibuat. Silakan isi absensi.');
    }

    /**
     * Show attendance taking form for a session.
     */
    public function take(Classroom $classroom, AttendanceSession $session)
    {
        $this->authorize('update', $classroom);

        $students = $classroom->students()->orderBy('name')->get();

        $attendances = $session->attendances()
            ->get()
            ->keyBy('student_id');

        return view('teacher.attendance.take', compact('classroom', 'session', 'students', 'attendances'));
    }

    /**
     * Store attendance for a session.
     */
    public function store(Classroom $classroom, AttendanceSession $session, Request $request)
    {
        $this->authorize('update', $classroom);

        $validated = $request->validate([
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:hadir,izin,sakit,alpha',
            'attendance.*.notes' => 'nullable|string|max:255',
        ]);

        foreach ($validated['attendance'] as $studentId => $data) {
            Attendance::updateOrCreate(
                [
                    'session_id' => $session->id,
                    'student_id' => $studentId,
                ],
                [
                    'classroom_id' => $classroom->id,
                    'date' => \Carbon\Carbon::parse($session->date)->format('Y-m-d'),
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                    'recorded_by' => auth()->id(),
                ]
            );
        }

        return redirect()
            ->route('teacher.attendance.index', $classroom)
            ->with('success', 'Absensi berhasil disimpan.');
    }

    /**
     * Show attendance detail for a session.
     */
    public function show(Classroom $classroom, AttendanceSession $session)
    {
        $this->authorize('view', $classroom);

        $students = $classroom->students()->orderBy('name')->get();

        $attendances = $session->attendances()
            ->get()
            ->keyBy('student_id');

        return view('teacher.attendance.show', compact('classroom', 'session', 'students', 'attendances'));
    }

    /**
     * Delete an attendance session.
     */
    public function destroySession(Classroom $classroom, AttendanceSession $session)
    {
        $this->authorize('update', $classroom);

        $session->delete();

        return redirect()
            ->route('teacher.attendance.index', $classroom)
            ->with('success', 'Sesi pertemuan berhasil dihapus.');
    }

    /**
     * Show attendance report for a classroom.
     */
    public function report(Classroom $classroom)
    {
        $this->authorize('view', $classroom);

        $students = $classroom->students()->orderBy('name')->get();
        $sessions = $classroom->attendanceSessions()->orderBy('session_number')->get();

        $attendances = Attendance::where('classroom_id', $classroom->id)
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

        return view('teacher.attendance.report', compact('classroom', 'students', 'sessions', 'summary'));
    }

    /**
     * Export attendance report to CSV.
     */
    public function exportReport(Classroom $classroom)
    {
        $this->authorize('view', $classroom);

        $students = $classroom->students()->orderBy('name')->get();
        $sessions = $classroom->attendanceSessions()->orderBy('session_number')->get();

        $attendances = Attendance::where('classroom_id', $classroom->id)
            ->get()
            ->groupBy('student_id');

        // Build CSV
        $filename = 'rekap_absensi_' . str_replace(' ', '_', $classroom->name) . '_' . date('Y-m-d') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () use ($classroom, $students, $sessions, $attendances) {
            $file = fopen('php://output', 'w');

            // Add BOM for Excel UTF-8 compatibility
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            // Title rows
            fputcsv($file, ['REKAP ABSENSI SISWA']);
            fputcsv($file, ['Kelas: ' . $classroom->name]);
            fputcsv($file, ['Mata Pelajaran: ' . ($classroom->subject ?? '-')]);
            fputcsv($file, ['Total Pertemuan: ' . $sessions->count()]);
            fputcsv($file, ['Tanggal Export: ' . date('d/m/Y H:i')]);
            fputcsv($file, []); // Empty row

            // Header row
            fputcsv($file, ['No', 'Nama Siswa', 'Hadir', 'Izin', 'Sakit', 'Alpha', 'Total', '% Kehadiran']);

            // Data rows
            $no = 1;
            foreach ($students as $student) {
                $studentAttendances = $attendances->get($student->id, collect());
                $hadir = $studentAttendances->where('status', 'hadir')->count();
                $izin = $studentAttendances->where('status', 'izin')->count();
                $sakit = $studentAttendances->where('status', 'sakit')->count();
                $alpha = $studentAttendances->where('status', 'alpha')->count();
                $total = $studentAttendances->count();
                $percentage = $total > 0 ? round(($hadir / $total) * 100, 1) : 0;

                fputcsv($file, [
                    $no++,
                    $student->name,
                    $hadir,
                    $izin,
                    $sakit,
                    $alpha,
                    $total,
                    $percentage . '%'
                ]);
            }

            // Summary row
            fputcsv($file, []);
            fputcsv($file, ['KETERANGAN:']);
            fputcsv($file, ['Hadir = Siswa mengikuti pembelajaran']);
            fputcsv($file, ['Izin = Siswa tidak hadir dengan izin resmi']);
            fputcsv($file, ['Sakit = Siswa tidak hadir karena sakit']);
            fputcsv($file, ['Alpha = Siswa tidak hadir tanpa keterangan']);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
