<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Hotel;
use App\Models\Room;


class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Book::where('hotel_id', 14)->paginate(10);
        $hotels = Hotel::where('id', 14)->get();
        $rooms = Room::where('hotel_id', 14)->get();
        $events = array();
        foreach ($bookings as $booking){
            $events[] = [
                'id' => $booking->id,
                'hotel_id' => $booking->hotel_id,
                'room_id' => $booking->room_id,
                'title' => $booking->title,
                'phone' => $booking->phone,
                'email' => $booking->email,
                'comment' => $booking->comment,
                'count' => $booking->count,
                'countc' => $booking->countc,
                'sum' => $booking->sum,
                'status' => $booking->status,
                'start' => $booking->start_d,
                'end' => $booking->end_d,
                //'color' => $color
            ];
        }
        return view('auth.hotel.books.index', compact('bookings', 'hotels', 'rooms', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        $hotel = Hotel::where('id', $book->hotel_id)->firstOrFail();
        $room = Room::where('id', $book->room_id)->firstOrFail();
        return view('auth.hotel.books.show', compact('book', 'hotel', 'room'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Book $book)
    {
        $book->delete();
        session()->flash('success', 'Бронирование ' . $book->title . ' удалено');
        return redirect()->route('hotel.books.index');
    }
}
