<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\FoodRequest;
use App\Models\Category;
use App\Models\Food;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foods = Food::paginate(10);
        return view('auth.foods.index', compact('foods'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('auth.foods.form');
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
        return view('auth.foods.form', compact('food'));
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
        Category::where('food_id', $food->id)->update(['food_id' => null]);
        //Mail::to('info@timmedia.store')->send(new RoomDeleteMail($room));
        session()->flash('success', 'Food ' . $food->title . ' deleted');
        return redirect()->route('foods.index');
    }
}
