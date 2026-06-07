<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    public function index()
    {
        return successResponse(User::all(), 'Users retrieved successfully');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return createdResponse($user, 'User created successfully');
    }

    public function show(User $user)
    {
        return successResponse($user, 'User retrieved successfully');
    }

    public function edit(User $user)
    {
        return successResponse($user, 'User edit data retrieved successfully');
    }

  public function update(UpdateSubscibitionRequest $request, Subscription $subscription)
{
    $subscription = $this->subscriptionService->update(
        $subscription,
        $request->validated()
    );

    dd($subscription);
}

    public function destroy(User $user)
    {
        $user->delete();

        return deletedResponse('User deleted successfully');
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->get();

        return successResponse($users, 'Trashed users retrieved successfully');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->restore();

        return successResponse($user, 'User restored successfully');
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->findOrFail($id);

        $user->forceDelete();

        return deletedResponse('User permanently deleted successfully');
    }
}
