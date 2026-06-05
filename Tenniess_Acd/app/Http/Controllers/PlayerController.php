<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;
use App\Models\Session;
use App\Models\Attendance;
class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $players =Player::all();
        return response()->json($players);
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
    public function store(StorePlayerRequest $request)
    {
        $players =Player::create($request->validated());
        return createdResponse('Player created successfully', $players);
    }

    /**
     * Display the specified resource.
     */
    public function show(Player $players)
    {
        return response()->json(['message'=>'player retrieved successfully','player'=>$players],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Player $players)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePlayerRequest $request, Player $players)
    {
        $players->update($request->validated());
        return updatedResponse('Player updated successfully', $players);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $players)
    {
        $players->destroy();
        return deletedResponse('Player deleted successfully', $players);
    }

    public function sessions(Player $players)
    {
        $sessions = $players->sessions()->with('coach')->get();
        return response()->json(['message'=>'player sessions retrieved successfully','sessions'=>$sessions]);
    }
    public function attendances(Player $players)
    {
        $attendances = $players->attendances()->with('session.coach')->get();
        return response()->json(['message'=>'player attendances retrieved successfully','attendances'=>$attendances]);
    }
    public function trashed(){
        $players = Player::onlyTrashed()->get();
        return response()->json($players);
    }

    public function rstore(Player $players){
        $players->restore();
        return restoredResponse('Player restored successfully', $players);
    }


    public function forceDelete(Player $players){
        $players->forceDelete();
        return deletedResponse('Player permanently deleted', $players);
    }
}
