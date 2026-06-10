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
        return createdResponse($players, 'Player created successfully');
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
public function update(UpdatePlayerRequest $request, Player $player)    {
        $player->update($request->validated());
        $player->refresh();
        return updatedResponse($player->toArray(), 'Player updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
  public function destroy(Player $player)
{
    $player->delete();

    return deletedResponse('Player deleted successfully');
}
   
    public function trashed(){
        $players = Player::onlyTrashed()->get();
        return response()->json($players);
    }

    public function rstore(Player $players){
        $players->restore();
        return restoredResponse($players, 'Player restored successfully');
    }


    public function forceDelete(Player $players){
        $players->forceDelete();
        return deletedResponse($players, 'Player permanently deleted');
    }
}
