<?php

namespace App\Http\Controllers\API\V1;

use App\Filters\V1\HotelFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\StoreHotelRequest;
use App\Http\Resources\V1\HotelCollection;
use App\Http\Resources\V1\HotelResource;
use App\Models\Hotel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    public function index(Request $request)
    {
        $filter = new HotelFilter();
        $queryItems = $filter->transform($request);//'column', 'operator', 'value'
        if(count($queryItems) == 0){
            return new HotelCollection(Hotel::paginate(1));
        } else {
            return new HotelCollection(Hotel::where($queryItems)->paginate(1));
        }

    }

    public function show(Hotel $hotel)
    {
        if($hotel == null) {
            abort(404);
        }
        return new HotelResource($hotel);
    }

    public function store(StoreHotelRequest $request)
    {
        return new HotelResource(Hotel::create($request->all()));
    }

    public function update(Request $request, Hotel $hotel)
    {
        $hotel->update($request->all());
    }
}
