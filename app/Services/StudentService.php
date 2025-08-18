<?php

namespace App\Services;

use App\Constants\Constants;
use App\Models\Student;
use App\Models\User;
use Faker\Provider\Base;
use Illuminate\Support\Facades\DB;

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

    public function createStudent(array $validatedData)
    {
        return DB::transaction(function () use ($validatedData) {
            $email = $validatedData['roll'] . '@gmail.com';
            $user = User::firstOrCreate(
                ['email' => $email], // search condition
                [
                    'name' => $validatedData['name'],
                    'password' => bcrypt('12345'),
                ]
            );
            $user->assignRole(Constants::ROLE_STUDENT);
            $validatedData['user_id'] = $user->id;
            $student = $this->create($validatedData);
            return $student;
        });
    }

    public function updateStudent(Student $student, $validatedData)
    {
        $result = DB::transaction(function () use($student, $validatedData) {
            $this->update($student, $validatedData);

            // Update user name
            if(isset($validatedData['name'])) {
                $user = $student->user;
                if($user) {
                    $user->name = $validatedData['name'];
                    $user->save();
                }
            }
            return $student;
        });
        return $result;
    }

    public function deleteStudent(Student $student)
    {
        return DB::transaction(function () use ($student) {
            $user = $student->user;
            if ($user) {
                $user->delete();
            }
            return $student->delete();
        });
    }
}
