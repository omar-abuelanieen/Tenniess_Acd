<?php

namespace App\Http\Controllers;

use App\Models\Player;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\StorePlayerRequest;
use App\Http\Requests\UpdatePlayerRequest;

class PlayerController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', Player::class);

        $players = Player::all();

        return response()->json($players);
    }

    public function store(StorePlayerRequest $request)
    {
        $this->authorize('create', Player::class);

        $player = Player::create($request->validated());

        return createdResponse($player, 'Player created successfully');
    }

    public function show(Player $player)
    {
        $this->authorize('view', $player);

        return response()->json([
            'message' => 'player retrieved successfully',
            'player' => $player
        ]);
    }

    public function update(UpdatePlayerRequest $request, Player $player)
    {
        $this->authorize('update', $player);

        $player->update($request->validated());
        $player->refresh();

        return updatedResponse($player->toArray(), 'Player updated successfully');
    }

    public function destroy(Player $player)
    {
        $this->authorize('delete', $player);

        $player->delete();

        return deletedResponse('Player deleted successfully');
    }

    public function trashed()
    {
        $this->authorize('viewAny', Player::class);

        $players = Player::onlyTrashed()->get();

        return response()->json($players);
    }

    public function restore(Player $player)
    {
        $this->authorize('restore', $player);

        $player->restore();

        return response()->json([
            'message' => 'Player restored successfully',
            'player' => $player,
        ]);
    }

    public function forceDelete(Player $player)
    {
        $this->authorize('forceDelete', $player);

        $player->forceDelete();

        return deletedResponse('Player permanently deleted');
    }
}
