<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'capacity'
    ];

    public function seats(): HasMany
    {
        return $this->hasMany(Seat::class);
    }
}
