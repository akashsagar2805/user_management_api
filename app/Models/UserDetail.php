<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'address_1', 'address_2', 'city', 'state', 'pincode'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
