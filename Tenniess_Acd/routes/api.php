<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CoacheController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\SubscribtionController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\UserSubscriptionController;

Route::prefix('auth')->controller(AuthController::class)->group(function () {

    Route::post('login', 'login')->middleware('login.rate.limit');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:api');
});

Route::prefix('users')->controller(UserController::class)->group(function () {

    Route::get('/', 'index');

    Route::get('/{user}', 'show');

    Route::middleware(['auth:api', 'is.admin'])->group(function () {

        Route::get('/trashed', 'trashed');

        Route::post('/', 'store');

        Route::put('/{user}', 'update');

        Route::delete('/{user}', 'destroy');

        Route::put('/{user}/restore', 'restore');

        Route::delete('/{user}/force', 'forceDelete');

        Route::get('/{user}/edit', 'edit');
    });
});

Route::prefix('roles')->controller(RoleController::class)->group(function () {

    Route::get('/', 'index');

    Route::get('/{role}', 'show');

    Route::middleware(['auth:api', 'is.admin'])->group(function () {

        Route::get('/trashed', 'trashed');

        Route::post('/', 'store');

        Route::put('/{role}', 'update');

        Route::delete('/{role}', 'destroy');

        Route::put('/{role}/restore', 'restore');

        Route::delete('/{role}/force', 'forceDelete');

        Route::get('/{role}/edit', 'edit');
    });
});
Route::prefix('coaches')->controller(CoacheController::class)->group(function () {

    Route::get('/', 'index');

    Route::get('/{coache}', 'show');

    Route::middleware(['auth:api', 'is.admin'])->group(function () {

        Route::post('/', 'store');

        Route::put('/{coache}', 'update');

        Route::delete('/{coache}', 'destroy');

        Route::put('/{coache}/restore', 'restore');

        Route::delete('/{coache}/force', 'forceDelete');

        Route::get('/trashed', 'trashed');

        Route::get('/{coache}/edit', 'edit');
    });
});

Route::prefix('players')->controller(PlayerController::class)->group(function () {

    Route::get('/', 'index');

    Route::get('/{player}', 'show');

    Route::middleware(['auth:api', 'is.admin'])->group(function () {

        Route::get('/trashed', 'trashed');

        Route::post('/', 'store');

        Route::put('/{player}', 'update');

        Route::delete('/{player}', 'destroy');

        Route::put('/{player}/restore', 'restore');

        Route::delete('/{player}/force', 'forceDelete');

        Route::get('/{player}/edit', 'edit');
    });
});

Route::prefix('sessions')->controller(SessionController::class)->group(function () {

    Route::get('/', 'index');

    Route::get('/{session}', 'show');

    Route::middleware(['auth:api', 'is.admin'])->group(function () {

        Route::post('/', 'store');

        Route::put('/{session}', 'update');

        Route::delete('/{session}', 'destroy');

        Route::get('/{session}/edit', 'edit');
    });
});

Route::prefix('attendances')->controller(AttendanceController::class)->group(function () {

    Route::get('/', 'index');

    Route::get('/{attendance}', 'show');

    Route::middleware(['auth:api', 'is.admin'])->group(function () {

        Route::post('/', 'store');

        Route::put('/{attendance}', 'update');

        Route::delete('/{attendance}', 'destroy');

        Route::get('/{attendance}/edit', 'edit');
    });
});


Route::post('/create-subscription-request', [UserSubscriptionController::class, 'store'])->middleware('throttle:subscription-request');


Route::prefix('subscriptions')
    ->controller(SubscribtionController::class)
    ->group(function () {

        Route::get('/', 'index');

        Route::get('/{subscription}', 'show')
            ->whereNumber('subscription');

        Route::middleware('auth:api')->group(function () {

            Route::get('/valid', 'validSubscriptions');


            Route::post('/', 'store');

            Route::put('/{subscription}', 'update')
                ->whereNumber('subscription');

            Route::get('/{subscription}/edit', 'edit')
                ->whereNumber('subscription');
        });

        Route::middleware(['auth:api', 'is.admin'])->group(function () {

            Route::get('/trashed', 'trashed');

            Route::get('/pending-requests', 'pending');

            Route::delete('/{subscription}', 'destroy')
                ->whereNumber('subscription');

            Route::patch('/{id}/activate', 'activate');

            Route::patch('/{id}/cancel', 'cancel');

            Route::patch('/{id}/freeze', 'freeze');

            Route::patch('/{id}/renew', 'renew');

            Route::patch('/{id}/approve', 'approve');

            Route::patch('/{id}/reject', 'reject');

            Route::patch('/{id}/restore', 'restore');

            Route::delete('/{id}/force-delete', 'forceDelete');

            Route::get('/expired', 'getExpiredSubscriptions');

        });
    });


Route::prefix('plans')->controller(PlanController::class)->group(function () {

    Route::get('/', 'index');

    Route::get('/{plan}', 'show');

    Route::middleware(['auth:api', 'is.admin'])->group(function () {

        Route::post('/', 'store');

        Route::put('/{plan}', 'update');

        Route::delete('/{plan}', 'destroy');

        Route::get('/{plan}/edit', 'edit');
    });
});
