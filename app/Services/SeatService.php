<?php

namespace App\Services;

use App\Models\Seat;

class SeatService extends BaseModelService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function model(): string
    {
        return Seat::class;
    }

    public function getEmptySeats()
    {
        return $this->model()::where('status', 'empty')->get();
    }
}
