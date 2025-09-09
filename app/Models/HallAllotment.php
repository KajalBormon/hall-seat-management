<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HallAllotment extends Model
{
    protected $fillable = [
        'hall_id',
        'student_id',
        'seat_id',
        'allotment_date',
        'status'
    ];

    public function hall()
    {
        return $this->belongsTo(Hall::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
