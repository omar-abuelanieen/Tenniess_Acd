<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {

    }

    public function boot(): void
    {
        
        RateLimiter::for('subscription-request', function (Request $request) {

            return Limit::perMinute(40)
                ->by('global-subscription');
        });


        Gate::define('admin', function ($user) {

            return $user->is_admin;
        });
    }
}
