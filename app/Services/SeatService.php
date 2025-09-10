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

    public function getSeatsForEdit($currentSeatId = null)
    {
        $user = auth()->user();
        $hallIds = is_array($user->halls) ? $user->halls : json_decode($user->halls, true);

        $query = $this->model()::where(function ($q) use ($hallIds) {
            $q->where('status', 'empty')
            ->whereHas('room', function ($q2) use ($hallIds) {
                $q2->whereIn('hall_id', $hallIds);
            });
        });

        // If editing, include the student's current seat even if it's occupied
        if ($currentSeatId) {
            $query->orWhere('id', $currentSeatId);
        }

        return $query->get();
    }
}
