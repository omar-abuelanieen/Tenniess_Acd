<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateSessionRequest;
use App\Http\Requests\StoreSessionRequest;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = Session::all();
        return response()->json($sessions);
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
    public function store(StoreSessionRequest $request)
    {
        $sessions = Session::create($request->validated());
        return createdResponse($sessions, 'Session created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Session $sessions)
    {
        return response()->json($sessions);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Session $sessions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
   public function update(UpdateSessionRequest $request, Session $session)
{
    $session->update($request->validated());

   $session->refresh();

return updatedResponse(
    $session->toArray(),
    'Session updated successfully'
);
}

    /**
     */
    public function destroy(Session $sessions)
    {
        $sessions->delete();
        return deletedResponse( 'Session deleted successfully');
    }
    public function players(Session $sessions)
    {
        $players = $sessions->players;
        return response()->json($players);
    }
    public function coaches(Session $sessions)
    {
        $coaches = $sessions->coaches;
        return response()->json($coaches);
    }
    public function attendances(Session $sessions)
    {
        $attendances = $sessions->attendances;
        return response()->json($attendances);
    }
    public function getSessionByPlayerId($playerId)
    {
        $sessions = Session::whereHas('players', function ($query) use ($playerId) {
            $query->where('player_id', $playerId);
        })->get();
        return response()->json($sessions);
    }
}
