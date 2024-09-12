<?php

namespace App\Http\Controllers\Buh;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotels = Hotel::paginate(10);
        return view('auth.hotels.buh.index', compact('hotels'));
    }

    public function show(Request $request, Hotel $hotel)
    {
        $users = Auth::user();
        $images = Image::where('hotel_id', $hotel->id)->get();
        $request->session()->put('hotel_id', $hotel->id);

        return view('auth.buh.hotels.show', compact('hotel', 'users', 'images'));
    }

}