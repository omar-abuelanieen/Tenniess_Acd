<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $session = Session::create($request->all());
        return response()->json(['message' => 'Session created successfully', 'session' => $session], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Session $session)
    {
        return response()->json($session);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Session $session)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Session $session)
    {
        $session->update($request->all());
        return response()->json(['message' => 'Session updated successfully', 'session' => $session]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Session $session)
    {
        $session->destory();
        return response()->json(['message' => 'Session deleted successfully']);
    }
    public function players(Session $session)
    {
        $players = $session->players;
        return response()->json($players);
    }
    public function coaches(Session $session)
    {
        $coaches = $session->coaches;
        return response()->json($coaches);
    }
    public function attendances(Session $session)
    {
        $attendances = $session->attendances;
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
