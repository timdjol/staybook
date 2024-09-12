<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Slider;
use App\Models\Vantage;


class HomeController extends Controller
{
    public function home()
    {
        $sliders = Slider::paginate(4);
        $vantages = Vantage::paginate(8);
        $faqs = Faq::paginate(8);
        return view('auth.home', compact('sliders', 'vantages', 'faqs'));
    }

}

