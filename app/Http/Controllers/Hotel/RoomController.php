<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Hotel;
use App\Models\Image;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::where('hotel_id', 14)->paginate(10);
        return view('auth.hotel.rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hotels = Hotel::all();
        return view('auth.hotel.rooms.form', compact('hotels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Room $room)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        unset($params['image']);
        if($request->has('image')){
            $path = $request->file('image')->store('rooms');
            $params['image'] = $path;
        }
        $room = Room::create($params);

        $images = $request->file('images');
        if ($request->hasFile('images')) :
            foreach ($images as $image):
                $image = $image->store('rooms');
                DB::table('images')->insert(
                    array(
                        'image'=>  $image,
                        'room_id' => $room->id,
                    )
                );
            endforeach;
        endif;

        session()->flash('success', 'Номер ' . $request->title . ' добавлен');
        return redirect()->route('hotel.rooms.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $images = Image::where('room_id', $room->id)->get();
        return view('auth.hotel.rooms.show', compact('room', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $hotels = Hotel::all();
        $images = Image::where('room_id', $room->id)->get();
        return view('auth.hotel.rooms.form', compact('room', 'hotels', 'images'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Room $room)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        unset($params['image']);

        ///image
        if ($request->has('image')) {
            Storage::delete($room->image);
            $params['image'] = $request->file('image')->store('rooms');
        }
        unset($params['images']);

        //images
        $images = $request->file('images');
        if ($request->hasFile('images')) {
            $dimages = Image::where('room_id', $room->id)->get();
            if ($dimages != null) {
                foreach ($dimages as $image){
                    Storage::delete($image->image);
                }
                DB::table('images')->where('room_id', $room->id)->delete();
            }
            foreach ($images as $image):
                $image = $image->store('rooms');
                DB::table('images')
                    ->where('room_id', $room->id)
                    ->updateOrInsert(['room_id' => $room->id, 'image' => $image]);
            endforeach;
        }

        $room->update($params);
        session()->flash('success', 'Номер ' . $request->title . ' обновлен');
        return redirect()->route('hotel.rooms.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        $room->delete();
        Storage::delete($room->image);
        $images = Image::where('room_id', $room->id)->get();
        foreach ($images as $image){
            Storage::delete($image->image);
        }
        DB::table('images')->where('room_id', $room->id)->delete();
        session()->flash('success', 'Номер ' . $room->title . ' удален');
        return redirect()->route('hotel.rooms.index');
    }

}
