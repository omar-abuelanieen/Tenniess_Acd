<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Session extends Model
{
    protected $fillable = ['player_id', 'start_time', 'end_time', 'coach_id'];

    protected $table = 'training_sessions';




    public function player()
    {
        return $this->belongsTo(Player::class);
    }


    public function coach()
    {
        return $this->belongsTo(Coache::class, 'coach_id');
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'training_session_id');
    }
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
   protected function startTime(): Attribute
{
    return Attribute::make(
        get: fn ($value) => \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s'),
    );
}

protected function endTime(): Attribute
{
    return Attribute::make(
        get: fn ($value) => \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s'),
    );
}
}
