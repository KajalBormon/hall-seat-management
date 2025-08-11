<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'roll',
        'registration',
        'name',
        'father_name',
        'mother_name',
        'email',
        'mobile_number',
        'address',
    ];
}
