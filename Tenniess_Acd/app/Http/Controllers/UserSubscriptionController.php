<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\UserSubscription;
use App\Http\Requests\StoreUserSubscriptionRequest;
use App\Http\Requests\UpdateUserSubscriptionRequest;

class UserSubscriptionController extends Controller
{
    public function store(StoreUserSubscriptionRequest $request)
    {
        $plan = Plan::findOrFail($request->plan_id);

        $subscription = UserSubscription::create([
            'player_id' => $request->player_id,
            'plan_id' => $plan->id,
            'status' => 'pending',
        ]);

        return createdResponse(
            $subscription->load(['player', 'plan']),
            'Subscription request sent successfully'
        );
    }

    public function update(UpdateUserSubscriptionRequest $request, string $id)
    {
        $subscription = UserSubscription::findOrFail($id);

        $subscription->update($request->validated());

        return successResponse(
            $subscription->fresh()->load(['player', 'plan']),
            'Subscription updated successfully'
        );
    }
}
