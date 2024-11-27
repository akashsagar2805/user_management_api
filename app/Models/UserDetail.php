<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    protected $fillable = [
        'user_id', 'address_1', 'address_2', 'city', 'state', 'pincode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
