<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;


class RoomController extends Controller
{
    /**
     * @return Collection
     */
    public function index()
    {
        return Room::all();
    }

    /**
     * @param Room $room
     * @return Room
     */
    public function show(Room $room)
    {
        if($room == null){
            abort(404);
        }
        return $room;
    }

//    /**
//     * @param Request $request
//     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
//     */
//    public function store(Request $request)
//    {
//        Room::create($request->all());
//        return response('Room created successfully.', 201);
//    }
//
//    /**
//     * @param Request $request
//     * @param Room $room
//     * @return Room
//     */
//    public function update(Request $request, Room $room)
//    {
//        $room->update($request->all());
//        return $room;
//    }
//
//    /**
//     * @param Room $room
//     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
//     */
//    public function destroy(Room $room)
//    {
//        $room->delete();
//        return response(null, 204);
//    }
}
