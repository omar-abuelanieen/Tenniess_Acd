<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Http\Requests\StoreSubscibitionRequest;
use App\Http\Requests\UpdateSubscibitionRequest;

class SubscribtionController extends Controller
{

    public function index()
    {
      $subscriptions= Subscription::with(['player', 'session'])->get();
      return successResponse($subscriptions, 'Subscriptions retrieved successfully');
    }



    public function store(StoreSubscibitionRequest $request)
    {
        $subscriptions= Subscription::create($request->validated());
        return createdResponse($subscriptions, 'Subscription created successfully');
    }

    public function show($id)
    {
        $subscription = Subscription::with(['player', 'session'])->findOrFail($id);

        return successResponse($subscription, 'Subscription retrieved successfully');
    }

     public function edit($id)
     {
         $subscription = Subscription::findOrFail($id);

         return successResponse($subscription, 'Subscription retrieved successfully for editing');
    }

    public function update(UpdateSubscibitionRequest $request, Subscription $subscription)
    {
        $subscription->update($request->validated());

        return updatedResponse($subscription, 'Subscription updated successfully');
    }

    public function validSubscriptions()
    {
        $subscriptions = Subscription::valid()->with(['player', 'session'])->get();

        return successResponse($subscriptions, 'Valid subscriptions retrieved successfully');
    }

    public function activate($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update(['status' => 'active']);
        return updatedResponse($subscription, 'Subscription activated successfully');
    }

    public function cancel($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update(['status' => 'cancelled']);
        return updatedResponse($subscription, 'Subscription cancelled successfully');
    }


    public function freeze($id)
    {
        $subscription = Subscription::findOrFail($id);
        $subscription->update(['status' => 'frozen']);
        return updatedResponse($subscription, 'Subscription frozen successfully');
    }
    public function renew($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscription->update([
            'status' => 'active',
            'start_date' => now(),
            'end_date' => now()->addMonth()
        ]);

        return updatedResponse($subscription, 'Subscription renewed successfully');
    }
    public function getExpiredSubscriptions()
    {
        $subscriptions = Subscription::expired()->with(['player', 'session'])->get();

        return successResponse($subscriptions, 'Expired subscriptions retrieved successfully');
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);

        $subscription->delete();

        return deletedResponse('Subscription deleted successfully');
    }

    public function createSubscriptionRequest(StoreSubscibitionRequest $request)
    {
        $subscription = Subscription::createSubscription($request->validated());

        return createdResponse($subscription, 'Subscription request created successfully');


    }
    public function pending()
{
    $requests = UserSubscription::with(['player', 'plan'])
        ->where('status', 'pending')
        ->get();

    return successResponse($requests, 'Pending requests');
}

   public function approve($id)
{
    $request = UserSubscription::findOrFail($id);

    $subscription = Subscription::create([
        'player_id' => $request->player_id,
        'session_id' => $request->session_id,
        'start_date' => now(),
        'end_date' => now()->addMonth(),
        'status' => 'active',
    ]);

    $request->update([
        'status' => 'approved'
    ]);

    return createdResponse($subscription, 'Subscription approved successfully');
}

    public function reject($id)
{
    $request = UserSubscription::findOrFail($id);

    $request->update([
        'status' => 'rejected'
    ]);

    return updatedResponse($request, 'Subscription request rejected');
}



    public function trashed()
    {
        $subscriptions = Subscription::onlyTrashed()->with(['player', 'session'])->get();

        return successResponse($subscriptions, 'Trashed subscriptions retrieved successfully');
    }

    public function restore($id)
    {
       $subscription = Subscription::withTrashed()->findOrFail($id);

        $subscription->restore();

        return successResponse($subscription, 'Subscription restored successfully');
    }

    public function forceDelete($id)
    {
        $subscription = Subscription::withTrashed()->findOrFail($id);

        $subscription->forceDelete();

        return deletedResponse('Subscription permanently deleted successfully');
    }

}
