<?php

namespace App\Services;

use App\Models\Student;
use Faker\Provider\Base;

class StudentService extends BaseModelService
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
        return Student::class;
    }

    public function getStudents()
    {
        return $this->model()::orderByDesc('created_at')->get();
    }
}
