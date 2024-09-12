<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\Controller;
use App\Http\Requests\HotelRequest;
use App\Models\Hotel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hotel = Hotel::where('id', 14)->firstOrFail();
        return view('auth.hotel.hotels.index', compact('hotel'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        return view('auth.hotel.hotels.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        return view('auth.hotel.hotels.form', compact('hotel'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HotelRequest $request, Hotel $hotel)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        unset($params['image']);
        if ($request->has('image')) {
            Storage::delete($hotel->image);
            $params['image'] = $request->file('image')->store('hotels');
        }

        $hotel->update($params);

        session()->flash('success', 'Отель ' . $request->title . ' обновлен');
        return redirect()->route('hotel.hotels.index');
    }

}
