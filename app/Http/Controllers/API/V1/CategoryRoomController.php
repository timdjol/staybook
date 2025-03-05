<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\CategoryRoom;
use Illuminate\Database\Eloquent\Collection;
class CategoryRoomController extends Controller
{
    /**
     * @return Collection
     */
    public function index()
    {
        return CategoryRoom::all();
    }

    /**
     * @param CategoryRoom $category
     * @return CategoryRoom
     */
    public function show(CategoryRoom $category){
        if($category == null){
            abort(404);
        }
        return $category;
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
