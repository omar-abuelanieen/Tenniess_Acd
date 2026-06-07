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
    return successResponse($this->subscriptionService->getAll(), 'Subscriptions retrieved successfully');
}

public function store(StoreSubscibitionRequest $request)
{
    $subscribtion = $this->subscriptionService->create($request->validated());

    return createdResponse($subscribtion, 'Subscription created successfully');
}

public function show(Subscribtion $subscribtion)
{
    return successResponse($subscribtion, 'Subscription retrieved successfully');
}

public function update(UpdateSubscibitionRequest $request, Subscribtion $subscribtion)
{
    $subscribtion = $this->subscriptionService->update($subscribtion, $request->validated());

    return updatedResponse($subscribtion, 'Subscription updated successfully');
}

public function validSubscriptions()
{
    return successResponse($this->subscriptionService->getValidSubscriptions(), 'Valid subscriptions retrieved successfully');
}

public function activate(Subscribtion $subscribtion)
{
    $subscribtion = $this->subscriptionService->activate($subscribtion);

    return updatedResponse($subscribtion, 'Subscription activated successfully');
}

public function cancel(Subscribtion $subscribtion)
{
    $subscribtion = $this->subscriptionService->cancel($subscribtion);

    return updatedResponse($subscribtion, 'Subscription cancelled successfully');
}

public function freeze(Subscribtion $subscribtion)
{
    $subscribtion = $this->subscriptionService->freezeSubscription($subscribtion);

    return updatedResponse($subscribtion, 'Subscription frozen successfully');
}

public function destroy(Subscribtion $subscribtion)
{
    $this->subscriptionService->delete($subscribtion);

    return deletedResponse('Subscription deleted successfully');
}

public function trashed()
{
    return successResponse($this->subscriptionService->getTrashed(), 'Trashed subscriptions retrieved successfully');
}

public function restore($id)
{
    $subscribtion = Subscribtion::withTrashed()->findOrFail($id);
    $subscribtion = $this->subscriptionService->restore($subscribtion);

    return successResponse($subscribtion, 'Subscription restored successfully');
}

public function forceDelete($id)
{
    $subscribtion = Subscribtion::withTrashed()->findOrFail($id);
    $this->subscriptionService->forceDelete($subscribtion);

    return deletedResponse('Subscription permanently deleted successfully');
}
}
