<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\UserSubscription;
use App\Http\Requests\StoreUserSubscriptionRequest;
use App\Http\Requests\UpdateUserSubscriptionRequest;
use Illuminate\Support\Facades\Auth;

class UserSubscriptionController extends Controller
{
    public function store(StoreUserSubscriptionRequest $request)
    {
        $player = Auth::user();

        $plan = Plan::findOrFail($request->plan_id);

        $exists = UserSubscription::where('player_id', $player->id)
            ->where('status', 'pending')
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'You already have a pending subscription request.'
            ], 400);
        }

        $subscription = UserSubscription::create([
            'player_id' => $player->id,
            'plan_id' => $plan->id,
            'status' => 'pending',
            'start_date'=>now()->toDateString(),
            'end_date'   => now()->addMonth()->toDateString(),
            'payment_status'  => 'unpaid',

        ]);

        return createdResponse(
            $subscription->load(['player', 'plan']),
            'Subscription request sent successfully. Waiting for admin approval.'
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
