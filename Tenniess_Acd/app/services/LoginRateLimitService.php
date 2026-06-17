<?php

namespace App\Services;

use App\Models\LoginAttempt;

class LoginRateLimitService
{
    public function check(string $email, string $ip): array
    {
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

            return [
                'blocked' => true,
                'email' => $email,
                'ip' => $ip,
                'retry_after' => now()->diffInSeconds($record->locked_until),
            ];
        }

        return [
            'blocked' => false,
        ];
    }

    public function failed(string $email, string $ip): void
    {
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

        $record->failed_attempts++;

        if ($record->failed_attempts >= 6) {

            $record->locked_until = now()->addDay();

            $record->failed_attempts = 0;

            $record->lock_level = 999;

            $record->save();

            return;
        }

        if ($record->failed_attempts >= 3) {

            $record->lock_level++;

            $minutes = 5 * (2 ** ($record->lock_level - 1));

            $record->locked_until = now()->addMinutes($minutes);

            $record->failed_attempts = 0;
        }

        $record->save();
    }

    public function success(string $email, string $ip): void
    {
        LoginAttempt::where('email', $email)
            ->where('ip_address', $ip)
            ->delete();
    }
}
