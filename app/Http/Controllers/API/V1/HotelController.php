<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Hotel;


class HotelController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        return view('index', compact('hotels'));
    }
}