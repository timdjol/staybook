<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Contact;
use App\Models\Food;
use App\Models\Image;
use App\Models\Page;
use App\Models\Product;
use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;


class PageController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        $rooms = Room::where('status', 1)->where('count', '>=', 1)->paginate(20);
        $foods = Food::all();
        return view('index', compact('hotels', 'rooms', 'foods'));
    }

    public function hotels()
    {
        $hotels = Hotel::orderBy('top', 'DESC')->get();
        return view('pages.hotels', compact('hotels'));
    }

    public function hotel($code)
    {
        $hotel = Hotel::where('code', $code)->first();
        $rooms = Room::where('hotel_id', $hotel->id)->paginate(10);
        return view('pages.hotel', compact('hotel', 'rooms'));
    }


    public function allrooms(
        $hotel = null,
        $price_from = null,
        $price_to = null,
        $count = null,
        $date_from = null,
        $date_to = null
    ) {
        $min = Category::whereNotNull('price')->min("price");
        $max = Category::whereNotNull('price')->max("price");
        $max_per = Room::whereNotNull('count')->max("count");

        $hotels = Hotel::all();

        if ($hotel == 0) {
            $hotel = null;
        } else {
            $hotel = $hotel;
        }

        if ($count == 0) {
            $count = null;
        } else {
            $count = $count;
        }

        $rooms = Room::query()->where('status', 1)->where('count', '>=', 1);

        if (isset($hotel) || $price_from !== null || $price_to !== null || isset($count) || $date_from !== null ||
            $date_to !== null) {
            $rooms = $rooms->where(function ($query) use ($hotel, $price_from, $price_to, $count, $date_from, $date_to)
            {
                if (isset($hotel)) {
                    $query->where('hotel_id', $hotel)->where('status', 1);
                } else {
                    $query->where('status', 1);
                }
                if ($price_from !== null) {
                    $query->where(function ($query) use ($price_from, $price_to)
                    {
                        $query->whereBetween('price', [$price_from, $price_to]);
                    });
                }
                if (isset($count)) {
                    $query->where('count', '>=', $count)->where('status', 1);
                } else {
                    $query->where('status', 1);
                }
//                if ($date_from !== null) {
//                    $query->where(function($query) use ($date_from, $date_to) {
//                        $query->whereBetween('pr ice', [$price_from, $price_to]);
//                    });
//                }
            });
        }

        $rooms = $rooms->paginate(10);

        return view('pages.rooms', compact('rooms', 'hotels', 'min', 'max', 'max_per'));
    }


    public function room($hotel, $roomCode)
    {
        $room = Room::withTrashed()->byCode($roomCode)->firstOrFail();
        $random = random_int(100000, 999999);
        $images = Image::where('room_id', $room->id)->get();
        //$related = Room::where('id', '!=', $room->id)->where('hotel_id', $room->hotel_id)->where('status', 1)->orderBy('price', 'asc')->get();
        $related = Room::where('id', '!=', $room->id)->where('hotel_id', $room->hotel_id)->where('status', 1)->get();
        return view('pages.room', compact('room', 'images', 'related', 'random'));
    }

    public function search(Request $request)
    {
        $random = random_int(100000, 999999);
        $start_d = $request->start_d;
        $end_d = $request->end_d;
        $count = $request->count;
        $countc = $request->countc;

        $query = Room::with('hotel', 'category');

        if ($request->filled('title')) {
            $title = (array) $request->input('title');
            $query->whereHas('hotel', function ($quer) use ($title) {
                $quer->where('title', $title);
                $quer->orWhere('title_en', $title);
                //$quer->orWhere('address', $title);
                //$quer->orWhere('address_en', $title);
            });
        }

//        if ($request->filled('start_d')) {
//            $start_d = (array) $request->input('start_d');
//            $query->whereHas('hotel', function ($quer) use ($start_d) {
//                $quer->where('start_d', $start_d);
//            });
//        }



        if ($request->filled('rating')) {
            $rating = (array) $request->input('rating');
            $query->whereHas('hotel', function ($quer) use ($rating) {
                $quer->where('rating', $rating);
            });
        }

//        if ($request->filled('include')) {
//            //$query->where('include', $request->include);
//            $food = (array) $request->input('include');
//            $query->whereHas('category', function ($quer) use ($food) {
//                $quer->where('food_id', $food);
//            });
//        }

        if ($request->filled('early_in')) {
            $early_in = (array) $request->input('early_in');
            $query->whereHas('hotel', function ($quer) use ($early_in) {
                $quer->where('early_in', $early_in);
            });
        }
        if ($request->filled('early_out')) {
            $early_out = (array) $request->input('early_out');
            $query->whereHas('hotel', function ($quer) use ($early_out) {
                $quer->where('early_out', $early_out);
            });
        }


        if ($request->filled('cancelled')) {
            $query->where('cancelled', '==', 0);
            $query->orWhere('cancelled', '==', '');
            $query->orWhere('cancelled', '==', null);
        }

//        if ($request->filled('extra_place')) {
//            $query->where('extra_place', '!=', '');
//            $query->orWhere('extra_place', '!=', null);
//            $query->orWhere('extra_place', '!=', 0);
//        }
        $rooms = $query->where('status', 1)->get();

        $contacts = Contact::get();

//        if ($request->filled('daterange')) {
//            $query->whereBetween('price',[$request->left_value, $request->right_value]);
//        }

        $relrooms = Room::all();


        return view('pages.search', compact('rooms', 'contacts','request', 'relrooms', 'random'));
    }

    public function about()
    {
        $page = Page::query()->where('id', 4)->first();
        return view('pages.about', compact('page'));
    }

    public function contactspage()
    {
        $page = Page::query()->where('id', 5)->first();;
        $contacts = Contact::get();
        return view('pages.contacts', compact('page', 'contacts'));
    }

    public function createStepOne(Request $request)
    {
        $product = $request->session()->get('product');

        return view('create-step-one',compact('product'));
    }


    public function postCreateStepOne(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:products',
            'amount' => 'required|numeric',
            'description' => 'required',
        ]);

        if(empty($request->session()->get('product'))){
            $product = new Product();
            $product->fill($validatedData);
            $request->session()->put('product', $product);
        }else{
            $product = $request->session()->get('product');
            $product->fill($validatedData);
            $request->session()->put('product', $product);
        }

        return redirect()->route('createStepTwo');
    }


    public function createStepTwo(Request $request)
    {
        $product = $request->session()->get('product');

        return view('create-step-two',compact('product'));
    }


    public function postCreateStepTwo(Request $request)
    {
        $validatedData = $request->validate([
            'stock' => 'required',
            'status' => 'required',
        ]);

        $product = $request->session()->get('product');
        $product->fill($validatedData);
        $request->session()->put('product', $product);

        return redirect()->route('createStepThree');
    }

    public function createStepThree(Request $request)
    {
        $product = $request->session()->get('product');

        return view('create-step-three',compact('product'));
    }

    public function postCreateStepThree(Request $request)
    {
        $product = $request->session()->get('product');
        $product->save();

        $request->session()->forget('product');

        return redirect()->route('index');
    }

}