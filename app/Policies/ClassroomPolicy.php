<?php

namespace App\Policies;

use App\Models\Classroom;
use App\Models\User;

class ClassroomPolicy
{
    /**
     * Determine if user can view the classroom.
     */
    public function view(User $user, Classroom $classroom): bool
    {
        return $classroom->isTeacher($user) || $classroom->hasMember($user);
    }

    /**
     * Determine if user can update the classroom.
     */
    public function update(User $user, Classroom $classroom): bool
    {
        return $classroom->isTeacher($user);
    }

    /**
     * Determine if user can delete the classroom.
     */
    public function delete(User $user, Classroom $classroom): bool
    {
        return $classroom->isTeacher($user);
    }
}
