<?php

namespace App\Http\Controllers;

use App\Models\Coache;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCoacheRequest;
use App\Http\Requests\UpdateCoacheRequest;
use App\Models\Session;
use App\Models\Attendance;
use App\Models\Player;
class CoacheController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coaches =Coache::with('sessions')->get();
        return response()->json($coaches);
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
    public function store(StoreCoacheRequest $request)
    {
        $coaches =Coache::create($request->validated());
        return createdResponse('Coache created successfully', $coaches);
    }

    /**
     * Display the specified resource.
     */
    public function show(Coache $coaches)
    {
        return response()->json(['message'=>'coache retrieved successfully','coache'=>$coaches]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Coache $coaches)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCoacheRequest $request, Coache $coaches)
    {
        $coaches->update($request->validated());
        return updatedResponse('Coache updated successfully', $coaches);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Coache $coaches)
    {
        $coaches->destroy();
        return deletedResponse('Coache deleted successfully', $coaches);
    }

    public function sessions(Coache $coaches)
    {
        $sessions = $coaches->sessions()->with('player')->get();
        return response()->json(['message'=>'coache sessions retrieved successfully','sessions'=>$sessions]);
    }

    public function attendances(Coache $coaches)
    {
        $attendances = $coaches->attendances()->with('session.player')->get();
        return response()->json(['message'=>'coache attendances retrieved successfully','attendances'=>$attendances]);
    }

    public function players(Coache $coaches)
    {
        $players = $coaches->sessions()->with('player')->get()->pluck('player')->unique('id')->values();
        return response()->json(['message'=>'coache players retrieved successfully','players'=>$players]);
    }
    public function trashed(){
        $coaches =Coache::onlyTrashed()->get();
        return response()->json($coaches);
    }
    public function rstore(Coache $coaches){
        $coaches->restore();
        return restoredResponse('Coache restored successfully', $coaches);
    }

    public function forceDelete(Coache $coaches){
        $coaches->forceDelete();
        return deletedResponse('Coache permanently deleted', $coaches);
    }
}
