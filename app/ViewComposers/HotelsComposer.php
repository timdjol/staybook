<?php

namespace App\ViewComposers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HotelsComposer
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function compose(View $view){
        $hotels = Hotel::get();
        $hotel_id = $this->request->session()->get('hotel_id');
        $view->with('hotels', $hotels)->with('hotel_id', $hotel_id);
    }
}