<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSubscription extends Model
{
    protected $table = 'subscription_requests';

    protected $fillable = [
        'player_id',
        'plan_id',
        'start_date',
        'end_date',
        'status',
        'payment_status',

    ];

    
    public function player()
    {
        return $this->belongsTo(Player::class);
    }


public function plan()
{
    return $this->belongsTo(Plan::class, 'plan_id');
}
}
