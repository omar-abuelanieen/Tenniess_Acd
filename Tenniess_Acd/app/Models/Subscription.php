<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Subscription extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'player_id',
        'plan_id',
        'start_date',
        'end_date',
    ];

    protected $guarded = [
        'status',
        'payment_status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'string',
        'payment_status' => 'string',
    ];

    public function player()
    {
        return $this->belongsTo(Player::class)->withDefault();
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class)->withDefault();
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value)
        );
    }

    protected function paymentStatus(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value)
        );
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
