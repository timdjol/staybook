<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\Image;
use App\Models\Page;
use App\Models\Product;
use App\Models\Room;
use App\Models\Hotel;
use Illuminate\Http\Request;


class PageController extends Controller
{
    public function homepage()
    {

//        $client = new \GuzzleHttp\Client();
//
//        $response = $client->request('GET', 'https://openapi.emergingtravel.com/');
//        dd($response->getBody());

        //Http::response('', '', 'Authorization: Basic bG9sOnNlY3VyZQ==');
        //$response = Http::get('https://openapi.emergingtravel.com/', 'Stay', 'stay123');

        $hotels = Hotel::all();
        $rooms = Room::where('status', 1)->where('count', '>=', 1)->orderBy('price', 'ASC')->paginate(20);
        return view('pages.home', compact('rooms', 'hotels'));
    }

    public function hotels()
    {
        $hotels = Hotel::orderBy('top', 'DESC')->get();
        return view('pages.hotels', compact('hotels'));
    }

    public function hotel($code)
    {
        $hotel = Hotel::where('code', $code)->first();
        $rooms = Room::where('hotel_id', $hotel->id)->orderBy('price', 'ASC')->paginate(10);
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
        $min = Room::whereNotNull('price')->min("price");
        $max = Room::whereNotNull('price')->max("price");
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

        $rooms = Room::query()->where('status', 1)->where('count', '>=', 1)->orderBy('price', 'asc');;

        if (isset($hotel) || $price_from !== null || $price_to !== null || isset($count) || $date_from !== null ||
            $date_to !== null) {
            $rooms = $rooms->where(function ($query) use ($hotel, $price_from, $price_to, $count, $date_from, $date_to)
            {
                if (isset($hotel)) {
                    $query->where('hotel_id', $hotel)->where('status', 1);
                } else {
                    $query->where('status', 1)->orderBy('price', 'asc');
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
                    $query->where('status', 1)->orderBy('price', 'asc');
                }
//                if ($date_from !== null) {
//                    $query->where(function($query) use ($date_from, $date_to) {
//                        $query->whereBetween('price', [$price_from, $price_to]);
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
        $related = Room::where('id', '!=', $room->id)->where('hotel_id', $room->hotel_id)->where('status', 1)->orderBy
        ('price', 'asc')
            ->get();
        return view('pages.room', compact('room', 'images', 'related', 'random'));
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