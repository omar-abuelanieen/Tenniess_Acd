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
        return response()->json(['message'=>'player created successfully','player'=>$players],201);
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
        return response()->json(['message'=>'player updated successfully','player'=>$players]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Player $players)
    {
        $players->destroy();
        return response()->json(['message'=>'player deleted successfully']);
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
        return response()->json(['message'=>'player restored successfully','player'=>$players],200);
    }


    public function forceDelete(Player $players){
        $players->forceDelete();
        return response()->json(['message'=>'player permanently deleted'],200);
    }
}
