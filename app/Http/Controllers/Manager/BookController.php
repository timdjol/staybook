<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Hotel;
use App\Models\Room;


class BookController extends Controller
{
    public function index()
    {
        $bookings = Book::all();


        $hotel_id = (int) request()->hotels;
        $room_id = (int) request()->rooms;
        if(request()->hotels){
            $bookings = Book::where('hotel_id', $hotel_id)->get();
        }
        if(request()->rooms){
            $bookings = Book::where('hotel_id', $hotel_id)->where('room_id', $room_id)->get();
        }


        $hotels = Hotel::all();
        $rooms = Room::all();
        $events = array();

//        $time_from = '2024-03-21';
//        $time_to = '2024-03-22';
//        $count = 5;
//        $rooms = Room::whereNotIn('id', function($query) use ($time_from, $time_to) {
//            $query->from('books')
//                ->select('room_id')
//                ->where('count', 5)
//                ->where('start_d', '<=', $time_to)
//                ->where('end_d', '>=', $time_from);
//        })->get();

        $removed = Book::onlyTrashed()->get();

        foreach ($bookings as $booking){
//            $color = null;
//            if($booking->room_id == 1){
//                $color = 'red';
//            }
//            if($booking->room_id == 2){
//                $color = 'orange';
//            }
//            if($booking->room_id == 3){
//                $color = 'green';
//            }
//            if($booking->room_id == 4){
//                $color = 'purple';
//            }

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
        return view('auth.manager.books.index', compact('bookings', 'hotels', 'rooms', 'events'));
    }

    public function show(Book $book)
    {
        $hotel = Hotel::where('id', $book->hotel_id)->firstOrFail();
        $room = Room::where('id', $book->room_id)->firstOrFail();
        $book->withTrashed()->get();
        return view('auth.manager.books.show', compact('book', 'hotel', 'room'));
    }

    public function destroy(Book $book)
    {
        $book->delete();
        session()->flash('success', 'Бронирование ' . $book->title . ' удалено');
        return redirect()->route('manager.listbooks.index');
    }
}
