<?php

namespace App\Http\Requests\Student;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
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
        $studentId = $this->route('student')->id;

        return [
            'roll'          => 'required|integer|unique:students,roll,' . $studentId,
            'registration'  => 'required|string|max:20|unique:students,registration,' . $studentId,
            'name'          => 'required|string|max:255',
            'father_name'   => 'nullable|string|max:255',
            'mother_name'   => 'nullable|string|max:255',
            'email'         => 'nullable|email|unique:students,email,' . $studentId,
            'mobile_number' => 'required|string|max:11|unique:students,mobile_number,' . $studentId,
            'address'       => 'nullable|string|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'roll.required' => 'The roll field is required.',
            'registration.required' => 'The registration field is required.',
            'name.required' => 'The name field is required.',
            'mobile_number.required' => 'The mobile number field is required.',
        ];
    }
}
