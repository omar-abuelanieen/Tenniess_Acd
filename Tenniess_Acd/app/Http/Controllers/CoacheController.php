<?php

namespace App\Http\Controllers;

use App\Models\Coache;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Http\Requests\StoreCoacheRequest;
use App\Http\Requests\UpdateCoacheRequest;

class CoacheController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', Coache::class);

        $coaches = Coache::with('sessions')->get();

        return response()->json($coaches);
    }

    public function store(StoreCoacheRequest $request)
    {
        $this->authorize('create', Coache::class);

        $coache = Coache::create($request->validated());

        return createdResponse($coache, 'Coache created successfully');
    }

    public function show(Coache $coache)
    {
        $this->authorize('view', $coache);

        return response()->json([
            'message' => 'coache retrieved successfully',
            'coache' => $coache
        ]);
    }

    public function update(UpdateCoacheRequest $request, Coache $coache)
    {
        $this->authorize('update', $coache);

        $coache->update($request->validated());

        return updatedResponse($coache, 'Coache updated successfully');
    }

    public function destroy(Coache $coache)
    {
        $this->authorize('delete', $coache);

        $coache->delete();

        return deletedResponse('Coache deleted successfully');
    }

    public function sessions(Coache $coache)
    {
        $this->authorize('view', $coache);

        $sessions = $coache->sessions()->with('player')->get();

        return response()->json([
            'message' => 'coache sessions retrieved successfully',
            'sessions' => $sessions
        ]);
    }

    public function attendances(Coache $coache)
    {
        $this->authorize('view', $coache);

        $attendances = $coache->attendances()->with('session.player')->get();

        return response()->json([
            'message' => 'coache attendances retrieved successfully',
            'attendances' => $attendances
        ]);
    }

    public function players(Coache $coache)
    {
        $this->authorize('view', $coache);

        $players = $coache->sessions()
            ->with('player')
            ->get()
            ->pluck('player')
            ->unique('id')
            ->values();

        return response()->json([
            'message' => 'coache players retrieved successfully',
            'players' => $players
        ]);
    }

    public function trashed()
    {
        $this->authorize('viewAny', Coache::class);

        $coaches = Coache::onlyTrashed()->get();

        return response()->json($coaches);
    }

    public function restore(Coache $coache)
    {
        $this->authorize('restore', $coache);

        $coache->restore();

        return response()->json([
            'message' => 'Coache restored successfully',
            'coache' => $coache
        ]);
    }

    public function forceDelete(Coache $coache)
    {
        $this->authorize('forceDelete', $coache);

        $coache->forceDelete();

        return deletedResponse('Coache permanently deleted');
    }
}
