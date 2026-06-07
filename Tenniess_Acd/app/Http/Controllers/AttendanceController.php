<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all();

        return successResponse($attendances, 'Attendances retrieved successfully');
    }

    public function store(StoreAttendanceRequest $request)
    {
        $attendance = Attendance::create($request->validated());

        return createdResponse($attendance, 'Attendance created successfully');
    }

    public function show(Attendance $attendance)
    {
        return successResponse($attendance, 'Attendance retrieved successfully');
    }

    public function update(UpdateAttendanceRequest $request, Attendance $attendance)
    {
        $attendance->update($request->validated());

        return updatedResponse($attendance, 'Attendance updated successfully');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return deletedResponse('Attendance deleted successfully');
    }

    public function getAttendanceByPlayerId($playerId)
    {
        $attendances = Attendance::where('player_id', $playerId)->get();

        return successResponse($attendances, 'Player attendances retrieved successfully');
    }

    public function getAttendanceBySessionId($sessionId)
    {
        $attendances = Attendance::where('training_session_id', $sessionId)->get();

        return successResponse($attendances, 'Session attendances retrieved successfully');
    }

}