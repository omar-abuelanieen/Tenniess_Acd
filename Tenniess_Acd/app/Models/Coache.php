<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
class Coache extends Model
{
    use SoftDeletes;
    protected $fillable = ['name', 'user_id', 'role_id', 'expertise'];




    public function user()
    {
        return $this->belongsTo(User::class);
    }



    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }
    protected $casts = [
        'name' => 'string',
        'experience' => 'integer',
    ];
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value)
        );
}
}
