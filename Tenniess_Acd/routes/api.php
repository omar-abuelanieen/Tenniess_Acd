<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CoacheController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SubscribtionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlanController;

Route::post('/login', [AuthController::class, 'login']) ->name('login') ->middleware('login.rate.limit');
 Route::post('/register', [AuthController::class, 'register'])->name('register');
 Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::prefix('users')->group(function () {

    Route::get('/', [UserController::class, 'index']);
    Route::get('/{user}', [UserController::class, 'show']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/trashed', [UserController::class, 'trashed']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
        Route::put('/{user}/restore', [UserController::class, 'restore']);
        Route::delete('/{user}/force', [UserController::class, 'forceDelete']);
         Route::get('/{user}/edit', [UserController::class, 'edit']);

    });
});

Route::prefix('roles')->group(function () {

    Route::get('/', [RoleController::class, 'index']);
    Route::get('/{role}', [RoleController::class, 'show']);

    Route::middleware('auth:api')->group(function () {
        Route::get('/trashed', [RoleController::class, 'trashed']);
        Route::post('/', [RoleController::class, 'store']);
        Route::put('/{role}', [RoleController::class, 'update']);
        Route::delete('/{role}', [RoleController::class, 'destroy']);
        Route::put('/{role}/restore', [RoleController::class, 'restore']);
        Route::delete('/{role}/force', [RoleController::class, 'forceDelete']);
         Route::get('/{role}/edit', [RoleController::class, 'edit']);
    });
});

Route::prefix('coaches')->group(function () {

    Route::get('/', [CoacheController::class, 'index']);
    Route::get('/{coache}', [CoacheController::class, 'show']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/', [CoacheController::class, 'store']);
        Route::put('/{coache}', [CoacheController::class, 'update']);
        Route::delete('/{coache}', [CoacheController::class, 'destroy']);
        Route::put('/{coache}/restore', [CoacheController::class, 'restore']);
        Route::delete('/{coache}/force', [CoacheController::class, 'forceDelete']);
        Route::get('/trashed', [CoacheController::class, 'trashed']);
        Route::get('/{coache}/edit', [CoacheController::class, 'edit']);

    });
});

Route::prefix('players')->group(function () {

    Route::get('/', [PlayerController::class, 'index']);

    Route::get('/{player}', [PlayerController::class, 'show']);

    Route::middleware('auth:api')->group(function () {
         Route::get('/trashed', [PlayerController::class, 'trashed']);
        Route::post('/', [PlayerController::class, 'store']);
        Route::put('/{player}', [PlayerController::class, 'update']);
        Route::delete('/{player}', [PlayerController::class, 'destroy']);
        Route::put('/{player}/restore', [PlayerController::class, 'restore']);
        Route::delete('/{player}/force', [PlayerController::class, 'forceDelete']);
         Route::get('/{player}/edit', [PlayerController::class, 'edit']);

    });
});

Route::prefix('sessions')->group(function () {

    Route::get('/', [SessionController::class, 'index']);
    Route::get('/{session}', [SessionController::class, 'show']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/', [SessionController::class, 'store']);
        Route::put('/{session}', [SessionController::class, 'update']);
        Route::delete('/{session}', [SessionController::class, 'destroy']);
        Route::get('/{session}/edit', [SessionController::class, 'edit']);
    });
});

Route::prefix('attendances')->group(function () {

    Route::get('/', [AttendanceController::class, 'index']);
    Route::get('/{attendance}', [AttendanceController::class, 'show']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/', [AttendanceController::class, 'store']);
        Route::put('/{attendance}', [AttendanceController::class, 'update']);
        Route::delete('/{attendance}', [AttendanceController::class, 'destroy']);
         Route::get('/{attendance}/edit', [AttendanceController::class, 'edit']);

    });
});

Route::prefix('subscriptions')->group(function () {

    Route::get('/', [SubscribtionController::class, 'index']);

    Route::get('/{subscription}', [SubscribtionController::class, 'show'])->whereNumber('subscription');
    Route::get('/{subscription}/edit', [SubscribtionController::class, 'edit'])->whereNumber('subscription');

    Route::middleware('auth:api')->group(function () {
         Route::get('/trashed', [SubscribtionController::class, 'trashed']);
    Route::get('/valid', [SubscribtionController::class, 'validSubscriptions']);
    Route::get('/expired', [SubscribtionController::class, 'getExpiredSubscriptions']);
    Route::get('/pending-requests', [SubscribtionController::class, 'pending']);
        Route::post('/', [SubscribtionController::class, 'store']);
        Route::put('/{subscription}', [SubscribtionController::class, 'update'])->whereNumber('subscription');
        Route::delete('/{subscription}', [SubscribtionController::class, 'destroy'])->whereNumber('subscription');
        Route::patch('/{id}/activate', [SubscribtionController::class, 'activate']);
        Route::patch('/{id}/cancel', [SubscribtionController::class, 'cancel']);
        Route::patch('/{id}/freeze', [SubscribtionController::class, 'freeze']);
        Route::patch('/{id}/renew', [SubscribtionController::class, 'renew']);
        Route::post('/create-subscription-request', [SubscribtionController::class, 'createSubscriptionRequest']);
        Route::patch('/{id}/approve', [SubscribtionController::class, 'approve']);
        Route::patch('/{id}/reject', [SubscribtionController::class, 'reject']);
        Route::patch('/{id}/restore', [SubscribtionController::class, 'restore']);
        Route::delete('/{id}/force-delete', [SubscribtionController::class, 'forceDelete']);

    });
});

Route::prefix('plans')->group(function () {

    Route::get('/', [PlanController::class, 'index']);
    Route::get('/{plan}', [PlanController::class, 'show']);
    Route::get('/{plan}/edit', [PlanController::class, 'edit']);

    Route::middleware('auth:api')->group(function () {
        Route::post('/', [PlanController::class, 'store']);
        Route::put('/{plan}', [PlanController::class, 'update']);
        Route::delete('/{plan}', [PlanController::class, 'destroy']);
    });
});
