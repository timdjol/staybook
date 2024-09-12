<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Page;
use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function dashboard()
    {
        $books = Book::get();
        $hotels = Hotel::get();
        $rooms = Room::get();
        $users = Auth::user();
        //$pages = Page::get();

        return view('auth.dashboard',
            compact('users', 'rooms','books', 'hotels'));
    }

}

