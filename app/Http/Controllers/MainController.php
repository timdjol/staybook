<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use App\Mail\BookMail;
use App\Models\Book;
use App\Models\Contact;
use App\Models\Hotel;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class MainController extends Controller
{
    public function index()
    {
        $hotels = Hotel::all();
        $rooms = Room::where('status', 1)->where('count', '>=', 1)->paginate(20);
        return view('index', compact('hotels', 'rooms'));
    }

    public function changeLocale($locale)
    {
        $availableLocales = ['ru', 'en'];
        if (!in_array($locale, $availableLocales)) {
            $locale = config('app.locale');
        }
        session(['locale' => $locale]);
        App::setLocale($locale);
        return redirect()->back();
    }

    public function contact_mail(Request $request)
    {
        Mail::to('info@timmedia.store')->send(new ContactMail($request));
        session()->flash('success', 'Заявка ' . $request->name . ' отправлена');
        return redirect()->route('contactspage');
    }

    public function book_mail(Request $request)
    {
        $params = $request->all();
        Book::create($params);
        Mail::to('info@timmedia.store')->cc($request->email)->send(new BookMail($request));
        session()->flash('success', 'Booking ' . $request->title . ' is created');
        return redirect()->route('homepage');
    }


    public function search(Request $request)
    {

        $start_d = $request->start_d;
        $end_d = $request->end_d;
        $count = $request->count;
        $countc = $request->countc;
        $age1 = $request->age1;
        $age2 = $request->age2;
        $age3 = $request->age3;

        //$hotel = Hotel::where('title', $request->title)->firstOrFail();
        //$reservedCount = Book::where('hotel_id', $hotel->id)->whereBetween('start_d', [$start_d, $end_d])->count();


        $query = Room::with('hotel');

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

        if ($request->filled('include')) {
            $query->where('include', $request->include);
        }

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

        if ($request->filled('extra_place')) {
            $query->where('extra_place', '!=', '');
            $query->orWhere('extra_place', '!=', null);
            $query->orWhere('extra_place', '!=', 0);
        }
        $rooms = $query->get();



        $contacts = Contact::get();

//        if ($request->filled('daterange')) {
//            $query->whereBetween('price',[$request->left_value, $request->right_value]);
//        }


        return view('search', compact('rooms', 'contacts', 'start_d', 'end_d', 'count', 'countc', 'age1', 'age2', 'age3'));
    }


}
