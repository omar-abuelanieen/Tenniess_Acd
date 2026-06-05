<?php

namespace App\Services;

use App\Models\Subscription;

class SubscriptionService
{
    public function getAll()
    {
        return Subscription::with(['player', 'session'])->get();
    }

    public function create(array $data): Subscription
    {
        return Subscription::create($data);
    }

    public function update(Subscription $subscription, array $data): Subscription
    {
        $subscription->update($data);

        return $subscription->fresh();
    }

    public function getValidSubscriptions()
    {
        return Subscription::valid()->get();
    }

    public function activate(Subscription $subscription): Subscription
    {
        $subscription->update([
            'status' => 'active',
        ]);

        return $subscription->fresh();
    }

    public function cancel(Subscription $subscription): Subscription
    {
        $subscription->update([
            'status' => 'cancelled',
        ]);

        return $subscription->fresh();
    }

    public function freezeSubscription(Subscription $subscription): Subscription
    {
        $subscription->update([
            'status' => 'frozen',
        ]);

        return $subscription->fresh();
    }

    public function delete(Subscription $subscription): void
    {
        $subscription->delete();
    }

    public function getSubscriptionById($id): ?Subscription
    {
        return Subscription::find($id);
    }

    public function getTrashed()
    {
        return Subscription::onlyTrashed()->get();
    }

    public function restore(Subscription $subscription): Subscription
    {
        $subscription->restore();

        return $subscription;
    }

    public function forceDelete(Subscription $subscription): bool
    {
        return $subscription->forceDelete();
    }
}
