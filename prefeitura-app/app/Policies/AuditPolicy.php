<?php

namespace App\Policies;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AuditPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->perfil === 0;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Audit $audit): bool
    {
        return $user->perfil === 0;
    }
}