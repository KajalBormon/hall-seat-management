<?php

namespace App\Services;

use App\Models\HallAllotment;
use App\Models\Seat;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HallAllotmentService extends BaseModelService
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
        return HallAllotment::class;
    }

    public function getHallAllotments()
    {
        return $this->model()::with(['student', 'hall', 'seat'])->get();
    }

    public function getHallAllotmentByProvost()
    {
        $user = auth()->user();
        $hallIds = $user->halls;

        return $this->model()::with(['student', 'hall', 'seat'])
            ->whereIn('hall_id', $hallIds)
            ->get();
    }

    public function createHallAllotment(array $data)
    {
        return DB::transaction(function () use ($data) {
            $hallAllotment = $this->create($data);

            $student = Student::find($data['student_id']);
            $student->update([
                'hall_id' => $hallAllotment->hall_id,
                'hall_status' => 'alloted'
            ]);

            $seat = Seat::find($data['seat_id']);
            $seat->update([
                'status' => 'alloted'
            ]);

            return $hallAllotment;
        });
    }

    public function updateHallAllotment($hallAllotment, array $data)
    {
        return DB::transaction(function () use ($hallAllotment, $data) {
            // Store old seat_id before updating
            $oldSeatId = $hallAllotment->seat_id;

            // Update hall allotment
            $hallAllotment->update($data);

            // Update student's hall
            $student = Student::find($data['student_id']);
            $student->update([
                'hall_id' => $hallAllotment->hall_id
            ]);

            // Free the old seat if seat changed
            if ($oldSeatId && $oldSeatId != $hallAllotment->seat_id) {
                Seat::find($oldSeatId)?->update([
                    'status' => 'empty'
                ]);
            }

            // Mark new seat as allotted
            $newSeat = Seat::find($hallAllotment->seat_id);
            $newSeat->update([
                'status' => 'alloted'
            ]);

            return $hallAllotment;
        });
    }

    public function deleteHallAllotment($hallAllotment)
    {
        return DB::transaction(function () use ($hallAllotment) {
            // Reset student's hall_id
            $student = Student::find($hallAllotment->student_id);
            if ($student) {
                $student->update([
                    'hall_id' => null,
                    'hall_status' => null
                ]);
            }

            // Free the seat
            $seat = Seat::find($hallAllotment->seat_id);
            if ($seat) {
                $seat->update([
                    'status' => 'empty'
                ]);
            }

            // Delete hall allotment
            $hallAllotment->delete();

            return true;
        });
    }

    public function getCurrentYearMonths()
    {
        $year = now()->year;
        $months = [];

        for ($i = 1; $i <= 12; $i++) {
            $month = Carbon::createFromDate($year, $i, 1);
            $months[] = [
                'name' => $month->format('M - Y'), // Displayed label (e.g. "Jan - 2025")
                'value' => $month->format('Y-m'),  // Machine value (e.g. "2025-01")
            ];
        }

        return $months;
    }
}
