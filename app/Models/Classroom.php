<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Classroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'teacher_id',
        'subject',
        'grade',
        'academic_year',
        'semester',
        'cover_image',
        'status',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($classroom) {
            if (empty($classroom->code)) {
                $classroom->code = strtoupper(Str::random(6));
            }
        });
    }

    /**
     * Get the teacher who owns the classroom.
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get the students enrolled in the classroom.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'classroom_members')
            ->withPivot('role', 'joined_at')
            ->withTimestamps();
    }

    /**
     * Get only students.
     */
    public function students(): BelongsToMany
    {
        return $this->members()->wherePivot('role', 'student');
    }

    /**
     * Get the materials for the classroom.
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Get the assignments for the classroom.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get the announcements for the classroom.
     */
    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    /**
     * Check if user is a member.
     */
    public function hasMember(User $user): bool
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if user is the teacher.
     */
    public function isTeacher(User $user): bool
    {
        return $this->teacher_id === $user->id;
    }

    /**
     * Scope for active classrooms.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Get the schedules for the classroom.
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Get the attendances for the classroom.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get the attendance sessions for the classroom.
     */
    public function attendanceSessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class);
    }
}
