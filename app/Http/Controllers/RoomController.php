<?php

namespace App\Http\Controllers;

use App\Http\Requests\Room\CreateRoomRequest;
use App\Http\Requests\Room\UpdateRoomRequest;
use App\Models\Room;
use App\Services\RoomService;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Inertia\Inertia;

class RoomController extends Controller implements HasMiddleware
{
    protected RoomService $roomService;

    public function __construct(RoomService $roomService)
    {
        $this->roomService = $roomService;
    }

    public static function middleware(): array
    {
        return [
            new Middleware('permission:can-create-room', only: ['create', 'store']),
            new Middleware('permission:can-edit-room', only: ['edit', 'update', 'changeStatus']),
            new Middleware('permission:can-delete-room', only: ['destroy']),
            new Middleware('permission:can-view-room', only: ['index']),
            new Middleware('permission:can-view-details-room', only: ['show']),
        ];
    }

    public function index()
    {
        $breadcrumbs = Breadcrumbs::generate('rooms');
        $rooms = $this->roomService->getRooms();
        $responseData = [
            'rooms' => $rooms,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Seat Plans',
        ];
        return Inertia::render('Room/Index', $responseData);
    }

    public function create()
    {
        $breadcrumbs = Breadcrumbs::generate('createRoom');
        $responseData = [
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Create Seat Plan',
        ];
        return Inertia::render('Room/Create', $responseData);
    }

    public function store(CreateRoomRequest $request)
    {
        $validatedData = $request->validated();
        $room = $this->roomService->createRoom($validatedData);
        $status = $room ? 'success' : 'error';
        $message = $room ? 'Room created successfully.' : 'Room could not be created';
        return redirect()->route('rooms.index')->with($status, $message);
    }

    public function edit(Room $room)
    {
        $breadcrumbs = Breadcrumbs::generate('editRoom', $room);
        $responseData = [
            'room' => $room,
            'breadcrumbs' => $breadcrumbs,
            'pageTitle' => 'Update Seat Plan',
        ];
        return Inertia::render('Room/Create', $responseData);
    }

    public function update(UpdateRoomRequest $request, Room $room)
    {
        $validatedData = $request->validated();
        $room = $this->roomService->updateRoom($room,$validatedData);
        $status = $room ? 'success' : 'error';
        $message = $room ? 'Room updated successfully.' : 'Room could not be updated';
        return redirect()->route('rooms.index')->with($status, $message);
    }

    public function destroy(Room $room)
    {
        $isDeleted = $this->roomService->deleteRoom($room);
        $status = $isDeleted ? 'success' : 'error';
        $message = $isDeleted ? 'Room deleted successfully.' : 'Room could not be deleted';
        return redirect()->route('rooms.index')->with($status, $message);
    }

}
