<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Services\AttendanceService;
use App\Http\Requests\StoreAttendanceRequest;
use App\Http\Requests\UpdateAttendanceRequest;

class AttendanceController extends Controller
{

   public function index()
{
    return successResponse($this->attendanceService->getAll(), 'Attendances retrieved successfully');
}

public function store(StoreAttendanceRequest $request)
{
    $attendance = $this->attendanceService->create($request->validated());

    return createdResponse($attendance, 'Attendance created successfully');
}

public function show(Attendance $attendance)
{
    return successResponse($attendance, 'Attendance retrieved successfully');
}

public function update(UpdateAttendanceRequest $request, Attendance $attendance)
{
    $attendance = $this->attendanceService->update($attendance, $request->validated());

    return updatedResponse($attendance, 'Attendance updated successfully');
}

public function destroy(Attendance $attendance)
{
    $this->attendanceService->delete($attendance);

    return deletedResponse('Attendance deleted successfully');
}

public function getAttendanceByPlayerId($playerId)
{
    return successResponse(
        $this->attendanceService->getAttendanceByPlayerId($playerId),
        'Player attendances retrieved successfully'
    );
}

public function getAttendanceBySessionId($sessionId)
{
    return successResponse(
        $this->attendanceService->getAttendanceBySessionId($sessionId),
        'Session attendances retrieved successfully'
    );
}



public function trashed()
{
    return successResponse(
        $this->attendanceService->getTrashed(),
        'Trashed attendances retrieved successfully'
    );
}

public function restore($id)
{
    $attendance = Attendance::withTrashed()->findOrFail($id);

    $this->attendanceService->restore($attendance);

    return successResponse(
        $attendance,
        'Attendance restored successfully'
    );
}

public function forceDelete($id)
{
    $attendance = Attendance::withTrashed()->findOrFail($id);

    $this->attendanceService->forceDelete($attendance);

    return deletedResponse(
        'Attendance permanently deleted successfully'
    );
}
}
