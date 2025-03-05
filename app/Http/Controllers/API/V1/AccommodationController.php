<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use Illuminate\Database\Eloquent\Collection;


class AccommodationController extends Controller
{
    /**
     * @return Collection
     */
    public function index()
    {
        return Accommodation::all();
    }

    /**
     * @param Accommodation $accommodation
     * @return Accommodation
     */
    public function show(Accommodation $accommodation)
    {
        if($accommodation == null){
            abort(404);
        }
        return $accommodation;
    }
}
