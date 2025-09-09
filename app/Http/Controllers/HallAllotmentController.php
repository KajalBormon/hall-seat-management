<?php

namespace App\Http\Controllers;

use App\Http\Requests\HallAllotment\CreateHallAllotmentRequest;
use App\Http\Requests\HallAllotment\UpdateHallAllotmentRequest;
use App\Models\HallAllotment;
use App\Services\DepartmentService;
use App\Services\HallAllotmentService;
use App\Services\HallService;
use App\Services\SeatService;
use App\Services\StudentService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HallAllotmentController extends Controller
{
    protected HallAllotmentService $hallAllotmentService;
    protected StudentService $studentService;
    protected HallService $hallService;
    protected DepartmentService $departmentService;
    protected SeatService $seatService;

    public function __construct(HallAllotmentService $hallAllotmentService, StudentService $studentService, HallService $hallService, DepartmentService $departmentService, SeatService $seatService)
    {
        $this->hallAllotmentService = $hallAllotmentService;
        $this->studentService = $studentService;
        $this->hallService = $hallService;
        $this->departmentService = $departmentService;
        $this->seatService = $seatService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('hallAllotments');
        $hallAllotments = $this->hallAllotmentService->getHallAllotments();
        $responseData = [
            'hallAllotments' => $hallAllotments,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Hall Allotment List',
        ];

        return Inertia::render('HallAllotment/Index', $responseData);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $breadcrumbs = Breadcrumbs::generate('createHallAllotment');
        $studentId = $request->query('studentId');
        $students = $this->studentService->getStudentsWithOutAttachOrAllotment();
        $halls = $this->hallService->getHalls();
        $departments = $this->departmentService->getActiveDepartments();
        $seats = $this->seatService->getEmptySeats();

        $responseData = [
            'students' => $students,
            'halls' => $halls,
            'departments' => $departments,
            'seats' => $seats,
            'studentId' => $studentId,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Add Hall Allotment',
        ];
        return Inertia::render('HallAllotment/Create', $responseData);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateHallAllotmentRequest $request)
    {
        $validatedData = $request->validated();
        $hallAllotment = $this->hallAllotmentService->createHallAllotment($validatedData);
        $status = $hallAllotment ? 'success' : 'error';
        $message = $hallAllotment ? 'Hall Allotment created successfully' : 'Hall Allotment creation failed';
        return redirect()->route('hall-allotments.index')->with($status, $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(HallAllotment $hallAllotment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, HallAllotment $hallAllotment)
    {
        $breadcrumbs = Breadcrumbs::generate('createHallAllotment', $hallAllotment);
        $studentId = $request->query('studentId');
        $students = $this->studentService->getStudents();
        $halls = $this->hallService->getHalls();
        $departments = $this->departmentService->getActiveDepartments();
        $seats = $this->seatService->all();

        $responseData = [
            'hallAllotment' => $hallAllotment,
            'students' => $students,
            'halls' => $halls,
            'departments' => $departments,
            'seats' => $seats,
            'studentId' => $studentId,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Add Hall Allotment',
        ];
        return Inertia::render('HallAllotment/Create', $responseData);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateHallAllotmentRequest $request, HallAllotment $hallAllotment)
    {
        $validatedData = $request->validated();
        $hallAllotment = $this->hallAllotmentService->updateHallAllotment($hallAllotment, $validatedData);
        $status = $hallAllotment ? 'success' : 'error';
        $message = $hallAllotment ? 'Hall Allotment updated successfully' : 'Hall Allotment updated failed';
        return redirect()->route('hall-allotments.index')->with($status, $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(HallAllotment $hallAllotment)
    {
        $hallAllotment = $this->hallAllotmentService->deleteHallAllotment($hallAllotment);
        $status = $hallAllotment ? 'success' : 'error';
        $message = $hallAllotment ? 'Hall Allotment deleted successfully' : 'Hall Allotment deleted failed';
        return redirect()->route('hall-allotments.index')->with($status, $message);
    }
}
