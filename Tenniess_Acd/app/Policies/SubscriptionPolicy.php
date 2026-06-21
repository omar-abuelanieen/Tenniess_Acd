<?php

namespace App\Policies;

use App\Models\Subscription;
use App\Models\User;

class SubscriptionPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Subscription $subscription): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    public function update(User $user, Subscription $subscription): bool
    {
        return $user->is_admin;
    }

    public function delete(User $user, Subscription $subscription): bool
    {
        return $user->is_admin;
    }

    public function restore(User $user, Subscription $subscription): bool
    {
        return $user->is_admin;
    }

    public function forceDelete(User $user, Subscription $subscription): bool
    {
        return $user->is_admin;
    }
    public function activate(User $user): bool
{
    return $user->is_admin;
}

public function approve(User $user): bool
{
    return $user->is_admin;
}

public function reject(User $user): bool
{
    return $user->is_admin;
}

    public function getExpiredSubscriptions(User $user): bool
    {
        return $user->is_admin;
    }
}
