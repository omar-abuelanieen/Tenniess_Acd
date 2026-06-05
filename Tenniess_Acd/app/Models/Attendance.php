<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Attendance extends Model
{
    protected $fillable =['training_session_id', 'player_id', 'status'];

    public function session()
    {
        return $this->belongsTo(Session::class, 'training_session_id');
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? 'Present' : 'Absent',
        );
    }
    protected $casts = [
        'status' => 'boolean',
    ];
}
