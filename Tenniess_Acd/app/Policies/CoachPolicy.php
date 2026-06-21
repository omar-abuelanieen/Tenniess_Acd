<?php

namespace App\Policies;

use App\Models\Coache;
use App\Models\User;

class CoachPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Coache $coache): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Coache $coache): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Coache $coache): bool
    {
        return $user->is_admin;
    }

    public function restore(User $user, Coache $coache): bool
    {
        return $user->is_admin;
    }

    public function forceDelete(User $user, Coache $coache): bool
    {
        return $user->is_admin;
    }
}
