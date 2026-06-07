<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Services\SubscriptionService;
use App\Http\Requests\StoreSubscibitionRequest;
use App\Http\Requests\UpdateSubscibitionRequest;

class SubscribtionController extends Controller
{
    public function __construct(
        private SubscriptionService $subscriptionService
    ) {}

    public function index()
    {
        return successResponse(
            $this->subscriptionService->getAll(),
            'Subscriptions retrieved successfully'
        );
    }

    public function store(StoreSubscibitionRequest $request)
    {
        $subscription = $this->subscriptionService->create($request->validated());

        return createdResponse(
            $subscription,
            'Subscription created successfully'
        );
    }

    public function show($id)
    {
        $subscription = $this->subscriptionService->getSubscriptionById($id);

        return successResponse(
            $subscription,
            'Subscription retrieved successfully'
        );
    }

    public function update(UpdateSubscibitionRequest $request, $id)
    {
        $subscription = $this->subscriptionService->update(
            Subscription::findOrFail($id),
            $request->validated()
        );

        return updatedResponse(
            $subscription,
            'Subscription updated successfully'
        );
    }

    public function validSubscriptions()
    {
        return successResponse(
            $this->subscriptionService->getValidSubscriptions(),
            'Valid subscriptions retrieved successfully'
        );
    }

    public function activate($id)
    {
        $subscription = $this->subscriptionService->activate($id);

        return updatedResponse(
            $subscription,
            'Subscription activated successfully'
        );
    }

    public function cancel($id)
    {
        $subscription = $this->subscriptionService->cancel($id);

        return updatedResponse(
            $subscription,
            'Subscription cancelled successfully'
        );
    }

    public function freeze($id)
    {
        $subscription = $this->subscriptionService->freezeSubscription($id);

        return updatedResponse(
            $subscription,
            'Subscription frozen successfully'
        );
    }

    public function destroy($id)
    {
        $subscription = Subscription::findOrFail($id);

        $this->subscriptionService->delete($subscription);

        return deletedResponse('Subscription deleted successfully');
    }

    public function trashed()
    {
        return successResponse(
            $this->subscriptionService->getTrashed(),
            'Trashed subscriptions retrieved successfully'
        );
    }

    public function restore($id)
    {
        $subscription = $this->subscriptionService->restore($id);

        return successResponse(
            $subscription,
            'Subscription restored successfully'
        );
    }

    public function forceDelete($id)
    {
        $subscription = Subscription::withTrashed()->findOrFail($id);

        $this->subscriptionService->forceDelete($subscription);

        return deletedResponse('Subscription permanently deleted successfully');
    }
}