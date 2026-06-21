<?php

namespace App\Policies;

use App\Models\Player;
use App\Models\User;

class PlayerPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Player $player): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Player $player): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Player $player): bool
    {
        return $user->is_admin;
    }

    public function restore(User $user, Player $player): bool
    {
        return $user->is_admin;
    }

    public function forceDelete(User $user, Player $player): bool
    {
        return $user->is_admin;
    }
}
