<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Subscribtion extends Model
{
    use SoftDeletes;

  protected $fillable = ['player_id','training_session_id','status','payment_status'];



  public function player(){

      return $this->belongsTo(Player::class);

  }



    public function session()
    {
        return $this->belongsTo(Session::class, 'training_session_id');
    }

    protected $casts = [
        'status' => 'string',
        'payment_status' => 'string',
    ];

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
     public function scopeValid($query)
    {
        return $query->whereIn('status', [
            'active',
            'pending',
            'cancelled',
        ]);
    }

}
