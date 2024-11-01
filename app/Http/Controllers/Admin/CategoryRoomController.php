<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Mail\RoomCreateMail;
use App\Models\Category;
use App\Models\Food;
use App\Models\Room;
use App\Models\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $hotel = $request->session()->get('hotel_id');
        $rules = Rule::where('hotel_id', $hotel)->paginate(10);
        $categories = Category::where('hotel_id', $hotel)->paginate(10);

        return view('auth.categories.index', compact('hotel', 'categories', 'rules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $hotel = $request->session()->get('hotel_id');
        $rooms = Room::where('hotel_id', $hotel)->get();
        $foods = Food::all();
        $rules = Rule::where('hotel_id', $hotel)->get();
        return view('auth.categories.form', compact('rooms', 'hotel', 'foods', 'rules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        Category::create($params);
        //Mail::to('info@timmedia.store')->send(new RoomCreateMail($request));

        session()->flash('success', 'CategoryRoom ' . $request->title . ' created');
        return redirect()->route('categories.index');
    }

    /**
     * Display the specified resource.
     */

    public function edit(Request $request, Category $category)
    {
        $hotel = $request->session()->get('hotel_id');
        $rooms = Room::where('hotel_id', $hotel)->get();
        $foods = Food::all();
        $rules = Rule::where('hotel_id', $hotel)->get();
        return view('auth.categories.form', compact('category', 'hotel', 'rooms', 'foods', 'rules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        $category->update($params);
        //Mail::to('info@timmedia.store')->send(new RoomUpdateMail($request));
        session()->flash('success', 'CategoryRoom ' . $request->title . ' updated');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        //Mail::to('info@timmedia.store')->send(new RoomDeleteMail($room));

        session()->flash('success', 'CategoryRoom ' . $category->title . ' deleted');
        return redirect()->route('categories.index');
    }



}
