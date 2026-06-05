<?php

namespace App\Http\Controllers;

use App\Models\Subscribtion;
use App\Services\SubscribtionService;
use App\Http\Requests\StoreSubscibitionRequest;
use App\Http\Requests\UpdateSubscibitionRequest;

class SubscribtionController extends Controller
{
    public function __construct(
        private SubscribtionService $subscribtionService
    ) {}

 public function index()
{
    return successResponse($this->subscribtionService->getAll(), 'Subscriptions retrieved successfully');
}

public function store(StoreSubscibitionRequest $request)
{
    $subscribtion = $this->subscribtionService->create($request->validated());

    return createdResponse($subscribtion, 'Subscription created successfully');
}

public function show(Subscribtion $subscribtion)
{
    return successResponse($subscribtion, 'Subscription retrieved successfully');
}

public function update(UpdateSubscibitionRequest $request, Subscribtion $subscribtion)
{
    $subscribtion = $this->subscribtionService->update($subscribtion, $request->validated());

    return updatedResponse($subscribtion, 'Subscription updated successfully');
}

public function validSubscriptions()
{
    return successResponse($this->subscribtionService->getValidSubscriptions(), 'Valid subscriptions retrieved successfully');
}

public function activate(Subscribtion $subscribtion)
{
    $subscribtion = $this->subscribtionService->activate($subscribtion);

    return updatedResponse($subscribtion, 'Subscription activated successfully');
}

public function cancel(Subscribtion $subscribtion)
{
    $subscribtion = $this->subscribtionService->cancel($subscribtion);

    return updatedResponse($subscribtion, 'Subscription cancelled successfully');
}

public function freeze(Subscribtion $subscribtion)
{
    $subscribtion = $this->subscribtionService->freezeSubscription($subscribtion);

    return updatedResponse($subscribtion, 'Subscription frozen successfully');
}

public function destroy(Subscribtion $subscribtion)
{
    $this->subscribtionService->delete($subscribtion);

    return deletedResponse('Subscription deleted successfully');
}

public function trashed()
{
    return successResponse($this->subscribtionService->getTrashed(), 'Trashed subscriptions retrieved successfully');
}

public function restore($id)
{
    $subscribtion = Subscribtion::withTrashed()->findOrFail($id);
    $subscribtion = $this->subscribtionService->restore($subscribtion);

    return successResponse($subscribtion, 'Subscription restored successfully');
}

public function forceDelete($id)
{
    $subscribtion = Subscribtion::withTrashed()->findOrFail($id);
    $this->subscribtionService->forceDelete($subscribtion);

    return deletedResponse('Subscription permanently deleted successfully');
}
}
