<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Database\Eloquent\Collection;


class MealController extends Controller
{
    /**
     * @return Collection
     */
    public function index()
    {
        return Meal::all();
    }

    /**
     * @param Meal $meal
     * @return Meal
     */
    public function show(Meal $meal){
        if($meal == null){
            abort(404);
        }
        return $meal;
    }
}
