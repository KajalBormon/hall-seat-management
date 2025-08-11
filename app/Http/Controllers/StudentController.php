<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\CreateStudentRequest;
use App\Http\Requests\Student\UpdateStudentRequest;
use App\Models\Student;
use App\Services\StudentService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class StudentController extends Controller implements HasMiddleware
{
    protected StudentService $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-create-student', only: ['create', 'store']),
            new Middleware('permission:can-edit-student', only: ['edit', 'update', 'updatePassword', 'changeStatus']),
            new Middleware('permission:can-delete-student', only: ['destroy']),
            new Middleware('permission:can-view-student', only: ['index']),
            new Middleware('permission:can-view-details-student', only: ['show']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('studentList');
        $students = $this->studentService->getStudents();
        $responseData = [
            'students' => $students,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Students',
        ];
        return inertia('Student/Index', $responseData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('createStudent');
        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Create Student',
        ];
        return inertia('Student/Create', $responseData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateStudentRequest $request)
    {
        $validatedData = $request->validated();
        $student = $this->studentService->create($validatedData);
        $status = $student ? 'success' : 'error';
        $message = $student ? 'Student created successfully.' : 'Failed to create student.';
        return redirect()->route('students.index')->with($status, $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Student $student)
    {
        $breadcrumbs = Breadcrumbs::generate('editStudent', $student);
        $responseData = [
            'student' => $student,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Edit Student',
        ];
        return inertia('Student/Create', $responseData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStudentRequest $request, Student $student)
    {
        $validatedData = $request->validated();
        $student = $this->studentService->update($student,$validatedData);
        $status = $student ? 'success' : 'error';
        $message = $student ? 'Student updated successfully.' : 'Failed to updated student.';
        return redirect()->route('students.index')->with($status, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Student $student)
    {
        $student->delete();
        $status = 'success';
        $message = 'Student deleted successfully.';
        return redirect()->route('students.index')->with($status, $message);
    }
}
