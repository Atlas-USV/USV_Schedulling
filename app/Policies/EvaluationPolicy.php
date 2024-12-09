<?php

namespace App\Policies;

use App\Models\User;
use App\Shared\ERoles;
use App\Shared\EPermissions;

class EvaluationPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        // Example logic: Check if the user has the right role or permission
        return $user->hasRole(ERoles::ADMIN->value) || $user->hasRole(ERoles::SECRETARY->value) || $user->hasPermissionTo(EPermissions::CREATE_EXAMS->value);
    }

    public function propose(User $user){
        return $user->hasPermissionTo(EPermissions::PROPOSE_EXAM->value);
    }
}
