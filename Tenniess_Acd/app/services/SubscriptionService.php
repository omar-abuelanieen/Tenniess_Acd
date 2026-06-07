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

        return $subscription;
    }

    public function getValidSubscriptions()
    {
        return Subscription::valid()->get();
    }

    public function activate($id): Subscription
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->update([
            'status' => 'active'
        ]);

        return $subscription;
    }

    public function cancel($id): Subscription
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->update([
            'status' => 'cancelled'
        ]);

        return $subscription;
    }

    public function freezeSubscription($id): Subscription
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->update([
            'status' => 'frozen'
        ]);

        return $subscription;
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

    public function restore($id): Subscription
    {
        $subscription = Subscription::withTrashed()->findOrFail($id);

        $subscription->restore();

        return $subscription;
    }

    public function forceDelete(Subscription $subscription): bool
    {
        return $subscription->forceDelete();
    }
}