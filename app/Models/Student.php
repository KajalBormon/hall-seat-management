<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'department_id',
        'roll',
        'registration',
        'name',
        'father_name',
        'mother_name',
        'email',
        'mobile_number',
        'address',
        'hall_id',
        'hall_status',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department(): HasOne
    {
        return $this->hasOne(Department::class);
    }

    public function hall(): HasOne
    {
        return $this->hasOne(Hall::class);
    }
}
