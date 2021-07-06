<?php

namespace App\Policies;

use App\Student;
use App\User;
use App\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class StudentPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any students.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasRole([Role::ROLE_ADMINISTRATOR]);
    }

    /**
     * Determine whether the user can view the student.
     *
     * @param  \App\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function view(User $user, Student $student)
    {
        return $user->hasRole([Role::ROLE_ADMINISTRATOR]);
    }

    /**
     * Determine whether the user can create students.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasRole([Role::ROLE_ADMINISTRATOR]);
    }

    /**
     * Determine whether the user can update the student.
     *
     * @param  \App\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function update(User $user, Student $student)
    {
        return $user->hasRole([Role::ROLE_ADMINISTRATOR]);
    }

    /**
     * Determine whether the user can enable the student.
     *
     * @param  \App\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function enable(User $user, Student $student)
    {
        return $user->hasRole([Role::ROLE_ADMINISTRATOR])
               && !$student->is_active;
    }

    /**
     * Determine whether the user can disable the student.
     *
     * @param  \App\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function disable(User $user, Student $student)
    {
        return $user->hasRole([Role::ROLE_ADMINISTRATOR])
               && $student->is_active;
    }

    /**
     * Determine whether the user can delete the student.
     *
     * @param  \App\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function delete(User $user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can restore the student.
     *
     * @param  \App\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function restore(User $user, Student $student)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the student.
     *
     * @param  \App\User  $user
     * @param  \App\Student  $student
     * @return mixed
     */
    public function forceDelete(User $user, Student $student)
    {
        //
    }
}
