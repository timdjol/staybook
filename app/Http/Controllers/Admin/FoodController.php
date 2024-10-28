<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Models\Food;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hotel = $request->session()->get('hotel_id');
        $foods = Food::where('hotel_id', $hotel)->paginate(10);
        return view('auth.foods.index', compact('hotel', 'foods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $hotel = $request->session()->get('hotel_id');
        $rooms = Room::where('hotel_id', $hotel)->get();
        return view('auth.foods.form', compact('rooms', 'hotel'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FoodRequest $request)
    {
        $params = $request->all();
        Food::create($params);
        //Mail::to('info@timmedia.store')->send(new RoomCreateMail($request));

        session()->flash('success', 'Food ' . $request->title . ' created');
        return redirect()->route('foods.index');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Request $request, Food $food)
    {
        $hotel = $request->session()->get('hotel_id');
        $rooms = Room::where('hotel_id', $hotel)->get();
        return view('auth.foods.form', compact('food', 'hotel', 'rooms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(FoodRequest $request, Food $food)
    {
        $params = $request->all();
        $food->update($params);
        //Mail::to('info@timmedia.store')->send(new RoomUpdateMail($request));
        session()->flash('success', 'Food ' . $request->title . ' updated');
        return redirect()->route('foods.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Food $food)
    {
        $food->delete();
        //Mail::to('info@timmedia.store')->send(new RoomDeleteMail($room));
        session()->flash('success', 'Food ' . $food->title . ' deleted');
        return redirect()->route('foods.index');
    }
}
