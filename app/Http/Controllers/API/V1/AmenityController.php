<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Amenity;
use Illuminate\Database\Eloquent\Collection;


class AmenityController extends Controller
{

    /**
     * @return Collection
     */
    public function index()
    {
        return Amenity::all();
    }

    /**
     * @param Amenity $amenity
     * @return Amenity
     */
    public function show(Amenity $amenity){
        if($amenity == null){
            abort(404);
        }
        return $amenity;
    }
}
