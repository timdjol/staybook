<?php

namespace App\Http\Controllers\Manager;

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
    public function index($status=null, $show_result = null,  $s_query = null)
    {
        if($status == 3) {
            $status = null;
        }else{
            $status = $status;
        }

        if ($show_result == 'all') {
            $show_result = 500000;
        }elseif($show_result == '0'){
            $show_result = 10;
        }else{
            $show_result = $show_result;
        }

        if ($s_query == '0') {
            $s_query = null;
        }else{
            $s_query = $s_query;
        }

        $hotels = Hotel::query();

        if ($s_query !== null || isset($status) || $show_result) {
            $hotels = $hotels->where(function($query) use ($status, $s_query) {
                if (isset($status)) {
                    $query->where('status', $status);
                }
                if ($s_query !== null) {
                    $query->where(function($query) use ($s_query) {
                        $query->where('title', 'like', '%'.$s_query.'%');
                    });
                }
            });
        }
        $hotels = $hotels->paginate(intval($show_result));

        return view('auth.manager.hotels.index', compact('hotels', 'status','show_result', 's_query'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.manager.hotels.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HotelRequest $request)
    {
        $request['code'] = Str::slug($request->title);
        $params = $request->all();
        unset($params['image']);
        if($request->has('image')){
            $path = $request->file('image')->store('hotels');
            $params['image'] = $path;
        }
        Hotel::create($params);

        session()->flash('success', 'Отель ' . $request->title . ' добавлен');
        return redirect()->route('manager.hotels.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Hotel $hotel)
    {
        return view('auth.hotels.show', compact('hotel'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Hotel $hotel)
    {
        return view('auth.manager.hotels.form', compact('hotel'));
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
        return redirect()->route('manager.hotels.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();
        session()->flash('success', 'Отель ' . $hotel->title . ' удален');
        return redirect()->route('manager.hotels.index');
    }
}
