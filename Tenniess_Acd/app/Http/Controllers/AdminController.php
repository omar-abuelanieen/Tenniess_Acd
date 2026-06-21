<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\Player;
use App\Models\Coache;
use App\Models\Subscription;
use App\Models\Plan;

class AdminController extends Controller
{
    public function dashboard()
{
    Gate::authorize('admin');

    return response()->json([
        'success' => true,
        'message' => 'Dashboard data retrieved successfully',
        'data' => [
            'players_count' => Player::count(),
            'coaches_count' => Coache::count(),
            'subscriptions_count' => Subscription::count(),
            'active_subscriptions' => Subscription::where('status', 'active')->count(),
            'plan_count'=> Plan::count(),
        ]
    ], 200);
}
}
