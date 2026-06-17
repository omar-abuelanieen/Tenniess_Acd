<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LoginAttempt;

class LoginRateLimitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $email = $request->email;
        $ip = $request->ip();

        if (!$email) {
            return $next($request);
        }

        $record = LoginAttempt::firstOrCreate(
            [
                'email' => $email,
                'ip_address' => $ip,
            ],
            [
                'failed_attempts' => 0,
                'lock_level' => 0,
            ]
        );

        if ($record->locked_until && $record->locked_until->isFuture()) {

            return response()->json([
                'message' => 'Too many attempts. You are temporarily blocked.',
                'retry_after_seconds' => now()->diffInSeconds($record->locked_until),
            ], 429);
        }

        $response = $next($request);

        if ($response->getStatusCode() === 401 || $response->getStatusCode() === 403) {

            $record->failed_attempts++;

            if ($record->failed_attempts >= 6) {

                $record->locked_until = now()->addDay();
                $record->failed_attempts = 0;
                $record->lock_level = 999;

            } elseif ($record->failed_attempts >= 3) {

                $record->lock_level++;

                $minutes = 1 * (2 ** ($record->lock_level - 1));

                $record->locked_until = now()->addMinutes($minutes);

                $record->failed_attempts = 0;
            }

            $record->save();
        }

        if ($response->getStatusCode() === 200) {
            LoginAttempt::where('email', $email)
                ->where('ip_address', $ip)
                ->delete();
        }

        return $response;
    }
}
