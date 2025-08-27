<?php

namespace App\Http\Requests\Room;

use Illuminate\Foundation\Http\FormRequest;

class CreateRoomRequest extends FormRequest
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
            'room_number' => 'required|unique:rooms,room_number',
            'capacity' => 'nullable|integer|min:1',
        ];
    }

    public function messages(): array
    {
        return [
            'room_number.required' => 'The room number is required.',
            'room_number.unique'   => 'This room number is already taken.',
            'capacity.integer'     => 'The capacity must be a number.',
            'capacity.min'         => 'The capacity must be at least 1.',
        ];
    }
}
