<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Submission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'content',
        'file_path',
        'file_name',
        'external_link',
        'submitted_at',
        'is_late',
        'score',
        'feedback',
        'graded_by',
        'graded_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'graded_at' => 'datetime',
            'is_late' => 'boolean',
            'score' => 'integer',
        ];
    }

    /**
     * Get the assignment.
     */
    public function assignment(): BelongsTo
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * Get the student.
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * Get the grader.
     */
    public function grader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    /**
     * Submit the submission.
     */
    public function submit(): void
    {
        $assignment = $this->assignment;

        $this->update([
            'submitted_at' => now(),
            'status' => 'submitted',
            'is_late' => $assignment->due_date && now()->isAfter($assignment->due_date),
        ]);
    }

    /**
     * Grade the submission.
     */
    public function grade(int $score, ?string $feedback, User $grader): void
    {
        $this->update([
            'score' => $score,
            'feedback' => $feedback,
            'graded_by' => $grader->id,
            'graded_at' => now(),
            'status' => 'graded',
        ]);
    }

    /**
     * Calculate final score with late penalty.
     */
    public function getFinalScoreAttribute(): ?int
    {
        if ($this->score === null) {
            return null;
        }

        if ($this->is_late && $this->assignment->late_penalty_percent > 0) {
            $penalty = ($this->assignment->late_penalty_percent / 100) * $this->score;
            return max(0, $this->score - $penalty);
        }

        return $this->score;
    }

    /**
     * Scope for submitted submissions.
     */
    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted');
    }

    /**
     * Scope for graded submissions.
     */
    public function scopeGraded($query)
    {
        return $query->where('status', 'graded');
    }
}
