<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Room;


class RoomController extends Controller
{
    public function index()
    {
        return Room::all();
    }
}