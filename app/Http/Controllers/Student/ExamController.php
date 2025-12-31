<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAnswer;
use App\Models\ExamAttempt;
use App\Models\Classroom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    public function index()
    {
        $student = Auth::user();

        // Fetch exams where (is_active = true) OR (user has attempted it)
        $exams = Exam::with([
            'classroom',
            'attempts' => function ($q) use ($student) {
                $q->where('user_id', $student->id);
            }
        ])
            ->where(function ($q) use ($student) {
                $q->where('is_active', true)
                    ->orWhereHas('attempts', function ($q2) use ($student) {
                        $q2->where('user_id', $student->id)->whereNotNull('submitted_at');
                    });
            })
            ->latest()
            ->get();

        return view('student.exams.index', compact('exams'));
    }

    public function startAttempt(Exam $exam)
    {
        // Check availability
        if (!$exam->is_active) {
            return redirect()->route('student.exams.index')->with('error', 'Ujian belum dimulai atau sudah selesai.');
        }

        // Check if student already has an attempt
        $attempt = ExamAttempt::firstOrCreate(
            [
                'exam_id' => $exam->id,
                'user_id' => Auth::id()
            ],
            [
                'started_at' => now(),
                'status' => 'in_progress'
            ]
        );

        // If already submitted, prevent retake
        if ($attempt->submitted_at) {
            return redirect()->route('student.exams.index')->with('error', 'Anda sudah mengerjakan ujian ini.');
        }

        return redirect()->route('student.exams.take', $exam);
    }

    public function take(Exam $exam)
    {
        if (!$exam->is_active) {
            return redirect()->route('student.exams.index')->with('error', 'Ujian ini tidak aktif.');
        }

        // Check if already attempted
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', Auth::id())
            ->first();

        if ($attempt && $attempt->submitted_at) {
            return redirect()->route('student.exams.index')->with('info', 'Anda sudah menyelesaikan ujian ini.');
        }

        if (!$attempt) {
            $attempt = ExamAttempt::create([
                'exam_id' => $exam->id,
                'user_id' => Auth::id(),
                'started_at' => now(),
            ]);
        }

        $exam->load('questions');

        return view('student.exams.take', compact('exam', 'attempt'));
    }

    public function submit(Request $request, Exam $exam)
    {
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($attempt->submitted_at) {
            return redirect()->route('student.exams.index');
        }

        // Process answers
        $score = 0;
        $totalPoints = 0;

        $answers = $request->input('answers', []);

        foreach ($exam->questions as $question) {
            $submittedAnswer = $answers[$question->id] ?? null;
            $isCorrect = $submittedAnswer === $question->correct_answer;

            if ($isCorrect) {
                $score += $question->points;
            }
            $totalPoints += $question->points;

            ExamAnswer::updateOrCreate(
                [
                    'exam_attempt_id' => $attempt->id,
                    'exam_question_id' => $question->id,
                ],
                [
                    'answer' => $submittedAnswer,
                    'is_correct' => $isCorrect,
                ]
            );
        }

        // Calculate final score logic (e.g. 0-100 scale)
        // If points are arbitrary, maybe just sum. Or normalize to 100.
        // Let's assume points sum up to raw score for now.
        // Actually typical school exam = (score / total) * 100.

        $finalScore = $totalPoints > 0 ? round(($score / $totalPoints) * 100) : 0;

        $attempt->update([
            'submitted_at' => now(),
            'score' => $finalScore
        ]);

        return redirect()->route('student.exams.result', $exam);
    }

    public function result(Exam $exam)
    {
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', Auth::id())
            ->with('answers')
            ->firstOrFail();

        $score = $attempt->score;
        $correct = $attempt->answers->where('is_correct', true)->count();
        $wrong = $attempt->answers->where('is_correct', false)->count();

        return view('student.exams.result', compact('exam', 'attempt', 'score', 'correct', 'wrong'));
    }
    public function recordViolation(Request $request, Exam $exam)
    {
        $attempt = ExamAttempt::where('exam_id', $exam->id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if ($attempt->submitted_at) {
            return response()->json(['status' => 'already_submitted']);
        }

        $attempt->increment('violation_count');

        // Terminate if requested or violation count >= 1 (Strict mode: Langsung Berhenti)
        if ($request->input('terminate') || $attempt->violation_count >= 1) {
            // Auto submit
            $attempt->status = 'terminated';
            $attempt->submitted_at = now();

            // Strict Mode: Score becomes 0 on violation termination
            // "jika langsung melanggar akan di hentikan langsung ujiannya dan nilai 0"
            $attempt->score = 0;
            $attempt->save();

            return response()->json(['status' => 'terminated']);
        }

        return response()->json(['status' => 'recorded', 'count' => $attempt->violation_count]);
    }
}
