<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginAttempt extends Model
{
    protected $fillable = ['email', 'ip_address', 'failed_attempts', 'lock_level', 'locked_until'];


     protected $casts = [

        'locked_until' => 'datetime',

    ];
}
