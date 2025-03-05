<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Room;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class BookingController extends Controller
{
    /**
     * @return Collection
     */
    public function index()
    {
        return Book::all();
    }

    /**
     * @param Book $book
     * @return Book
     */
    public function show(Book $book)
    {
        if($book == null){
            abort(404);
        }
        return $book;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string'
        ]);
        $params = $request->all();
        $booking = Book::create($params);
        $room = Room::where('id', $request->room_id)->firstOrFail();
        $room->decrement('count', $request->count);

        return response()->json($booking);
        //return redirect()->route('books.index', $room->id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $booking = Book::find($id);
        if(!$booking){
            return response()->json([
                'error' => 'Unable to locate the event'
            ], 404);
        }
        $booking->update([
            'start_d' => $request->start_d,
            'end_d' => $request->end_d
        ]);
        return response()->json('Event updated');
    }
}
