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

    public function getEmptySeatByHallProvost()
    {
        $user = auth()->user();

        // Decode halls (cast in model if possible)
        $hallIds = is_array($user->halls) ? $user->halls : json_decode($user->halls, true);

        return $this->model()::where('status', 'empty')
            ->whereHas('room', function ($q) use ($hallIds) {
                $q->whereIn('hall_id', $hallIds);
            })
            ->get();
    }
}
