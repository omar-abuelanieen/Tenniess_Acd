<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Subscription extends Model
{




    use SoftDeletes;

  protected $fillable = ['player_id','plan_id','start_date','end_date'];

 protected $guarded = ['payment_status','status'];

  public function player(){

      return $this->belongsTo(Player::class);

  }



    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    protected $casts = [
        'status' => 'string',
        'payment_status' => 'string',
        'start_date' => 'date',
        'end_date' => 'date',
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
            'frozen',
            'expired',
            'approved',
            'rejected'
        ]);
    }


}
