<?php

namespace App\Http\Requests\HallAllotment;

use Illuminate\Foundation\Http\FormRequest;

class CreateHallAllotmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'hall_id' => 'required|exists:halls,id',
            'student_id' => 'required|exists:students,id',
            'seat_id' => 'required|exists:seats,id',
            'allotment_date' => 'required|date',
        ];
    }

    public function messages(): array
    {
        return [
            'hall_id.required' => 'The hall field is required.',
            'hall_id.exists'   => 'The selected hall is invalid.',

            'student_id.required' => 'The student field is required.',
            'student_id.exists'   => 'The selected student is invalid.',

            'seat_id.required' => 'The seat number is required.',
            'seat_id.string'   => 'The seat number must be a valid text value.',

            'allotment_date.required' => 'The allotment date is required.',
            'allotment_date.date'     => 'The allotment date must be a valid date.',
        ];
    }

}
