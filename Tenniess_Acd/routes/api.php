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
use App\Http\Controllers\UserSubscriptionController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');


Route::prefix('users')->group(function () {
    Route::get('/trashed', [UserController::class, 'trashed']);
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store'])->middleware('auth:api');
    Route::get('/{user}', [UserController::class, 'show']);
    Route::get('/{user}/edit', [UserController::class, 'edit']);
    Route::put('/{user}', [UserController::class, 'update'])->middleware('auth:api');
    Route::delete('/{user}', [UserController::class, 'destroy'])->middleware('auth:api');
 Route::put('/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
 Route::delete('/{user}/force', [UserController::class, 'forceDelete'])->name('users.forceDelete');
});


Route::prefix('roles')->group(function () {
     Route::get('/trashed', [RoleController::class, 'trashed'])->middleware('auth:api');
    Route::get('/', [RoleController::class, 'index']);
    Route::post('/', [RoleController::class, 'store'])->middleware('auth:api');
    Route::get('/{role}', [RoleController::class, 'show']);
    Route::get('/{role}/edit', [RoleController::class, 'edit']);
    Route::put('/{role}', [RoleController::class, 'update'])->middleware('auth:api');
    Route::delete('/{role}', [RoleController::class, 'destroy'])->middleware('auth:api');

Route::put('/{role}/restore', [RoleController::class, 'restore'])->name('roles.restore');
Route::delete('/{role}/force', [RoleController::class, 'forceDelete'])->name('roles.forceDelete');
});

Route::prefix('coaches')->group(function () {
    Route::get('/trashed', [CoacheController::class, 'trashed']);
    Route::get('/', [CoacheController::class, 'index']);
    Route::post('/', [CoacheController::class, 'store'])->middleware('auth:api');
    Route::get('/{coache}', [CoacheController::class, 'show']);
    Route::get('/{coache}/edit', [CoacheController::class, 'edit']);
    Route::put('/{coache}', [CoacheController::class, 'update'])->middleware('auth:api');
    Route::delete('/{coache}', [CoacheController::class, 'destroy'])->middleware('auth:api');
Route::put('/{coache}/restore', [CoacheController::class, 'restore'])->name('coaches.restore');
Route::delete('/{coache}/force', [CoacheController::class, 'forceDelete'])->name('coaches.forceDelete');

});


Route::prefix('players')->group(function () {
    Route::get('/trashed', [PlayerController::class, 'trashed']);
    Route::get('/', [PlayerController::class, 'index']);
    Route::post('/', [PlayerController::class, 'store'])->middleware('auth:api');
    Route::get('/{player}', [PlayerController::class, 'show']);
    Route::get('/{player}/edit', [PlayerController::class, 'edit']);
    Route::put('/{player}', [PlayerController::class, 'update'])->middleware('auth:api');
    Route::delete('/{player}', [PlayerController::class, 'destroy'])->middleware('auth:api');
Route::put('/{player}/restore', [PlayerController::class, 'restore'])->name('players.restore');
Route::delete('/{player}/force', [PlayerController::class, 'forceDelete'])->name('players.forceDelete');
});



Route::prefix('sessions')->group(function () {
    Route::get('/', [SessionController::class, 'index']);
    Route::post('/', [SessionController::class, 'store'])->middleware('auth:api');
    Route::get('/{session}', [SessionController::class, 'show']);
    Route::get('/{session}/edit', [SessionController::class, 'edit']);
    Route::put('/{session}', [SessionController::class, 'update'])->middleware('auth:api');
    Route::delete('/{session}', [SessionController::class, 'destroy'])->middleware('auth:api');
});





Route::prefix('attendances')->group(function () {
    Route::get('/', [AttendanceController::class, 'index']);
    Route::post('/', [AttendanceController::class, 'store'])->middleware('auth:api');
    Route::get('/{attendance}', [AttendanceController::class, 'show']);
    Route::get('/{attendance}/edit', [AttendanceController::class, 'edit']);
    Route::put('/{attendance}', [AttendanceController::class, 'update'])->middleware('auth:api');
    Route::delete('/{attendance}', [AttendanceController::class, 'destroy'])->middleware('auth:api');
});



Route::prefix('subscriptions')->group(function () {

    Route::get('/trashed', [SubscribtionController::class, 'trashed']);
    Route::get('/', [SubscribtionController::class, 'index']);
    Route::get('/{subscription}', [SubscribtionController::class, 'show']);
    Route::get('/{subscription}/edit', [SubscribtionController::class, 'edit']);

    Route::post('/', [SubscribtionController::class, 'store'])->middleware('auth:api');
    Route::put('/{subscription}', [SubscribtionController::class, 'update'])->middleware('auth:api');
    Route::delete('/{subscription}', [SubscribtionController::class, 'destroy'])->middleware('auth:api');

    Route::get('/valid', [SubscribtionController::class, 'validSubscriptions'])->middleware('auth:api');
    Route::get('/expired', [SubscribtionController::class, 'getExpiredSubscriptions'])->middleware('auth:api');

    Route::patch('/{id}/activate', [SubscribtionController::class, 'activate'])->middleware('auth:api');
    Route::patch('/{id}/cancel', [SubscribtionController::class, 'cancel'])->middleware('auth:api');
    Route::patch('/{id}/freeze', [SubscribtionController::class, 'freeze'])->middleware('auth:api');
    Route::patch('/{id}/renew', [SubscribtionController::class, 'renew'])->middleware('auth:api');

    Route::post('/create-subscription-request', [SubscribtionController::class, 'createSubscriptionRequest']);
    Route::get('/pending-requests', [SubscribtionController::class, 'pending'])->middleware('auth:api');
    Route::patch('/{id}/approve', [SubscribtionController::class, 'approve'])->middleware('auth:api');
    Route::patch('/{id}/reject', [SubscribtionController::class, 'reject'])->middleware('auth:api');

    Route::patch('/{id}/restore', [SubscribtionController::class, 'restore'])->middleware('auth:api');
    Route::delete('/{id}/force-delete', [SubscribtionController::class, 'forceDelete'])->middleware('auth:api');

});
