<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'roll',
        'registration',
        'name',
        'father_name',
        'mother_name',
        'email',
        'mobile_number',
        'address',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
