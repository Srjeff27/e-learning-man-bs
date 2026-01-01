<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Classroom;
use App\Models\Exam;
use App\Models\ExamQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get classrooms taught by the teacher (User ID)
        $user = Auth::user();

        // Ensure user is authorized teacher
        if (!$user->isGuru()) {
            abort(403, 'Unauthorized action.');
        }

        $classrooms = Classroom::where('teacher_id', $user->id)->pluck('id');
        $exams = Exam::whereIn('classroom_id', $classrooms)
            ->with('classroom')
            ->latest()
            ->paginate(10);

        return view('teacher.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Use User ID for teacher_id
        $classrooms = Classroom::where('teacher_id', Auth::id())->get();
        return view('teacher.exams.create', compact('classrooms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'classroom_id' => 'required|exists:classrooms,id',
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Exam::create($request->all());

        return redirect()->route('teacher.exams.index')->with('success', 'Ujian berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     * Used for managing questions.
     */
    public function show(Exam $exam)
    {
        $exam->load('questions');
        return view('teacher.exams.show', compact('exam'));
    }

    // Alias for edit if needed, but show covers question management
    public function edit(Exam $exam)
    {
        return view('teacher.exams.edit', compact('exam'));
    }

    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'duration_minutes' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $exam->update($request->all());
        return redirect()->route('teacher.exams.show', $exam)->with('success', 'Ujian diperbarui.');
    }

    public function destroy(Exam $exam)
    {
        if ($exam->attempts()->exists()) {
            return redirect()->back()->with('error', 'Ujian tidak dapat dihapus karena sudah ada siswa yang mengerjakannya.');
        }

        $exam->delete();
        return redirect()->route('teacher.exams.index')->with('success', 'Ujian dihapus.');
    }

    /**
     * Add a question to the exam.
     */
    public function addQuestion(Request $request, Exam $exam)
    {
        $request->validate([
            'question_text' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'option_c' => 'required|string',
            'option_d' => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'points' => 'required|integer|min:1',
        ]);

        $exam->questions()->create($request->all());

        return redirect()->route('teacher.exams.show', $exam)->with('success', 'Soal berhasil ditambahkan.');
    }

    public function destroyQuestion(Exam $exam, ExamQuestion $question)
    {
        $question->delete();
        return redirect()->route('teacher.exams.show', $exam)->with('success', 'Soal dihapus.');
    }

    public function start(Exam $exam)
    {
        $exam->update([
            'is_active' => true,
            'start_time' => now()
        ]);
        return redirect()->route('teacher.exams.monitor', $exam)
            ->with('success', 'Ujian dimulai! Anda sekarang berada di halaman monitor.');
    }

    public function stop(Exam $exam)
    {
        $exam->update([
            'is_active' => false,
            'end_time' => now()
        ]);
        return redirect()->route('teacher.exams.index')
            ->with('success', 'Ujian telah dihentikan.');
    }

    public function monitor(Exam $exam)
    {
        // Get all attempts for this exam
        // We load initial data, but the view will largely rely on JS for updates, 
        // OR we just use this for the initial page load.
        $attempts = $exam->attempts()->with('user')->latest()->get();
        return view('teacher.exams.monitor', compact('exam', 'attempts'));
    }

    public function history(Exam $exam)
    {
        $attempts = $exam->attempts()->with('user', 'answers')->latest()->get();
        // Pre-load questions count for calculation in view if needed, 
        // though in history view we access $exam->questions->count().
        // Better load it:
        $exam->load('questions');
        return view('teacher.exams.history', compact('exam', 'attempts'));
    }

    public function monitorData(Exam $exam)
    {
        $attempts = $exam->attempts()->with('user')->latest()->get()->map(function ($attempt) use ($exam) {

            // Calculate detailed stats if needed (or store them)
            // For now, let's count answers or rely on score.
            // If we want "Correct/Wrong", we need to query answers.
            // Optimization: Load answers? Or just count.
            // Let's assume we want real counts.
            $correct = $attempt->answers->where('is_correct', true)->count();
            $totalQuestions = $exam->questions->count(); // This might be N+1 if not careful, but Exam is loaded.
            $wrong = $attempt->answers->count() - $correct; // Answers submitted but wrong
            // Or unattempted?

            return [
                'user_name' => $attempt->user->name,
                'started_at' => $attempt->started_at->format('H:i'),
                'submitted_at' => $attempt->submitted_at ? $attempt->submitted_at->format('H:i') : '-',
                'score' => $attempt->score ?? '-',
                'status' => $attempt->status,
                'is_finished' => !is_null($attempt->submitted_at),
                'violation_count' => $attempt->violation_count,
                'correct' => $correct,
                'wrong' => $totalQuestions - $correct, // Assuming all questions count
            ];
        });

        return response()->json([
            'attempts' => $attempts,
            'summary' => [
                'total' => $attempts->count(),
                'finished' => $attempts->where('is_finished', true)->count(),
                'active' => $attempts->where('is_finished', false)->count(),
            ]
        ]);
    }
}
