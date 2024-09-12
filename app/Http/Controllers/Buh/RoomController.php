<?php

namespace App\Http\Controllers\Buh;

use App\Http\Controllers\Controller;
use App\Models\Room;
class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::paginate(10);
        return view('auth.buh.rooms.index', compact('rooms'));
    }

}
