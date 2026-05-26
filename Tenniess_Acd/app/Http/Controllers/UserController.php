<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users =User::all();
        return response()->json($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $users = User::create($request->validated());
        return response()->json(['message' => 'User created successfully', 'user' => $users], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $users)
    {
        return response()->json($users);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $users)
    {
        return response()->json(['message' => 'User edit form', 'user' => $users]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $users)
    {
        $users->update($request->validated());
        return response()->json(['message' => 'User updated successfully', 'user' => $users]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $users)
    {
        $users->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
    public function trashed(){
        $users = User::trashed()->get();
        return response()->json($users);
    }
    public function restore(User $users){
        if($users->trashed()){
            $users->restore();
            return response()->json(['message' => 'User restored successfully', 'user' => $users]);
        }else{
            return response()->json(['message' => 'User is not deleted', 'user' => $users]);
        }
    }
    public function forceDelete(User $users){
        if($users->trashed()){
            $users->forceDelete();
            return response()->json(['message' => 'User permanently deleted', 'user' => $users]);
        }else{
            return response()->json(['message' => 'User is not deleted', 'user' => $users]);
        }
    }
}
