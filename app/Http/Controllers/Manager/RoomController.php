<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Book;
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
    public function index($status=null, $show_result = null,  $s_query = null)
    {
        if($status == 3) {
            $status = null;
        }else{
            $status = $status;
        }

        if ($show_result == 'all') {
            $show_result = 500000;
        }elseif($show_result == '0'){
            $show_result = 10;
        }else{
            $show_result = $show_result;
        }

        if ($s_query == '0') {
            $s_query = null;
        }else{
            $s_query = $s_query;
        }

        $rooms = Room::query();

        if ($s_query !== null || isset($status) || $show_result) {
            $rooms = $rooms->where(function($query) use ($status, $s_query) {
                if (isset($status)) {
                    $query->where('status', $status);
                }
                if ($s_query !== null) {
                    $query->where(function($query) use ($s_query) {
                        $query->where('title', 'like', '%'.$s_query.'%');
                    });
                }
            });
        }
        $rooms = $rooms->paginate(intval($show_result));

        return view('auth.manager.rooms.index', compact('rooms', 'status','show_result', 's_query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hotels = Hotel::all();
        return view('auth.manager.rooms.form', compact('hotels'));
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
        return redirect()->route('manager.rooms.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        $images = Image::where('room_id', $room->id)->get();
        return view('auth.manager.rooms.show', compact('room', 'images'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        $hotels = Hotel::all();
        $images = Image::where('room_id', $room->id)->get();
        return view('auth.manager.rooms.form', compact('room', 'hotels', 'images'));
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
        return redirect()->route('manager.rooms.index');
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
        return redirect()->route('manager.rooms.index');
    }

}
