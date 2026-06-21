<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\UserSubscription;
use App\Http\Requests\StoreSubscibitionRequest;
use App\Http\Requests\UpdateSubscibitionRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SubscribtionController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $subscriptions = Subscription::with(['player', 'plan'])->get();

        return successResponse(
            $subscriptions,
            'Subscriptions retrieved successfully'
        );
    }

    public function store(StoreSubscibitionRequest $request)
    {
        $this->authorize('create', Subscription::class);

        $subscription = Subscription::create([
            'player_id' => $request->player_id,
            'plan_id' => $request->plan_id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => $request->status,
            'payment_status' => $request->payment_status,
        ]);

        return createdResponse(
            $subscription->load(['player', 'plan']),
            'Subscription created successfully'
        );
    }

    public function show($id)
    {
        $subscription = Subscription::with(['player', 'plan'])->findOrFail($id);

        return successResponse(
            $subscription,
            'Subscription retrieved successfully'
        );
    }

    public function edit($id)
    {
        $subscription = Subscription::findOrFail($id);

        return successResponse(
            $subscription,
            'Subscription retrieved successfully for editing'
        );
    }

    public function update(UpdateSubscibitionRequest $request, Subscription $subscription)
    {
        $this->authorize('update', $subscription);

        $subscription->update($request->validated());

        return updatedResponse(
            $subscription->fresh()->load(['player', 'plan']),
            'Subscription updated successfully'
        );
    }

    public function validSubscriptions()
    {
        $subscriptions = Subscription::valid()
            ->with(['player', 'plan'])
            ->get();

        return successResponse(
            $subscriptions,
            'Valid subscriptions retrieved successfully'
        );
    }

    public function activate($id)
    {
        $subscription = Subscription::findOrFail($id);

        $this->authorize('update', $subscription);

        $subscription->update([
            'status' => 'active'
        ]);

        return updatedResponse(
            $subscription,
            'Subscription activated successfully'
        );
    }

    public function cancel($id)
    {
        $subscription = Subscription::findOrFail($id);

        $this->authorize('update', $subscription);

        $subscription->update([
            'status' => 'cancelled'
        ]);

        return updatedResponse(
            $subscription,
            'Subscription cancelled successfully'
        );
    }

    public function freeze($id)
    {
        $subscription = Subscription::findOrFail($id);

        $this->authorize('update', $subscription);

        $subscription->update([
            'status' => 'frozen'
        ]);

        return updatedResponse(
            $subscription,
            'Subscription frozen successfully'
        );
    }

    public function renew($id)
    {
        $subscription = Subscription::findOrFail($id);

        $this->authorize('update', $subscription);

        $subscription->update([
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
        ]);

        return updatedResponse(
            $subscription,
            'Subscription renewed successfully'
        );
    }

    public function getExpiredSubscriptions()
    {
        $subscriptions = Subscription::expired()
            ->with(['player', 'plan'])
            ->get();

        return successResponse(
            $subscriptions,
            'Expired subscriptions retrieved successfully'
        );
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);

        $this->authorize('delete', $subscription);

        $subscription->delete();

        return deletedResponse(
            'Subscription deleted successfully'
        );
    }

    public function createSubscriptionRequest(StoreSubscibitionRequest $request)
    {
        $subscriptionRequest = UserSubscription::create([
            'player_id' => $request->player_id,
            'plan_id' => $request->plan_id,
            'status' => 'pending',
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'payment_status' => 'pending',
        ]);

        return createdResponse(
            $subscriptionRequest,
            'Subscription request created successfully'
        );
    }

    public function pending()
    {
        $requests = UserSubscription::with(['player', 'plan'])
            ->where('status', 'pending')
            ->get();

        return successResponse(
            $requests,
            'Pending requests retrieved successfully'
        );
    }

    public function approve($id)
    {
        $request = UserSubscription::findOrFail($id);

        $this->authorize('create', Subscription::class);

        $subscription = Subscription::create([
            'player_id' => $request->player_id,
            'plan_id' => $request->plan_id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => 'active',
            'payment_status' => 'pending',
        ]);

        $request->update([
            'status' => 'approved'
        ]);

        return createdResponse(
            $subscription,
            'Subscription approved successfully'
        );
    }

    public function reject($id)
    {
        $request = UserSubscription::findOrFail($id);

        $this->authorize('update', Subscription::class);

        $request->update([
            'status' => 'rejected'
        ]);

        return updatedResponse(
            $request,
            'Subscription request rejected'
        );
    }

    public function trashed()
    {
        $this->authorize('viewAny', Subscription::class);

        $subscriptions = Subscription::onlyTrashed()
            ->with(['player', 'plan'])
            ->get();

        return successResponse(
            $subscriptions,
            'Trashed subscriptions retrieved successfully'
        );
    }

    public function restore($id)
    {
        $subscription = Subscription::withTrashed()->findOrFail($id);

        $this->authorize('restore', $subscription);

        $subscription->restore();

        return successResponse(
            $subscription,
            'Subscription restored successfully'
        );
    }

    public function forceDelete($id)
    {
        $subscription = Subscription::withTrashed()->findOrFail($id);

        $this->authorize('forceDelete', $subscription);

        $subscription->forceDelete();

        return deletedResponse(
            'Subscription permanently deleted successfully'
        );
    }
}
