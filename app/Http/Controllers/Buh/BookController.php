<?php

namespace App\Http\Controllers\Buh;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Hotel;
use App\Models\Room;


class BookController extends Controller
{
    public function index()
    {
        $bookings = Book::all();
        $hotels = Hotel::all();
        $rooms = Room::all();
        return view('auth.buh.books.index', compact('bookings', 'hotels', 'rooms'));
    }
}
