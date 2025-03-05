<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Rate;
use Illuminate\Database\Eloquent\Collection;
class RateController extends Controller
{
    /**
     * @return Collection
     */
    public function index()
    {
        return Rate::all();
    }

    /**
     * @param Rate $rate
     * @return Rate
     */
    public function show(Rate $rate){
        if($rate == null){
            abort(404);
        }
        return $rate;
    }

//    public function store()
//    {
//
//    }
//
//    /**
//     * @param Request $request
//     * @param Rate $category
//     * @return Rate
//     */
//    public function update(Request $request, Rate $category)
//    {
//        $category->update($request->all());
//        return $category;
//    }
//
//    /**
//     * @param Rate $category
//     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
//     */
//    public function destroy(Rate $category)
//    {
//        $category->delete();
//        return response(null, 204);
//    }
}
