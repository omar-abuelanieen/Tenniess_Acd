<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CoacheController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AttendanceController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/users/trashed', [UserController::class, 'trashed']);

Route::apiResource('users',UserController::class);
 Route::put('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');
 Route::delete('/users/{user}/force', [UserController::class, 'forceDelete'])->name('users.forceDelete');



 Route::get('/roles/trashed', [RoleController::class, 'trashed']);
Route::apiResource('roles',RoleController::class);
Route::put('/roles/{role}/restore', [RoleController::class, 'restore'])->name('roles.restore');
Route::delete('/roles/{role}/force', [RoleController::class, 'forceDelete'])->name('roles.forceDelete');


Route::get('/coaches/trashed', [CoacheController::class, 'trashed']);
Route::apiResource('coaches',CoacheController::class);
Route::put('/coaches/{coache}/restore', [CoacheController::class, 'restore'])->name('coaches.restore');
Route::delete('/coaches/{coache}/force', [CoacheController::class, 'forceDelete'])->name('coaches.forceDelete');



Route::get('/players/trashed', [PlayerController::class, 'trashed']);
Route::apiResource('players',PlayerController::class);
Route::put('/players/{player}/restore', [PlayerController::class, 'restore'])->name('players.restore');
Route::delete('/players/{player}/force', [PlayerController::class, 'forceDelete'])->name('players.forceDelete');



Route::apiResource('sessions',SessionController::class);





Route::apiResource('attendances',AttendanceController::class);

