<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RuleController extends Controller
{
    /**
     * @return Collection
     */
    public function index()
    {
        return Rule::all();
    }

    /**
     * @param Rule $rule
     * @return Rule
     */
    public function show(Rule $rule){
        if($rule == null){
            abort(404);
        }
        return $rule;
    }

//    /**
//     * @param Request $request
//     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
//     */
//    public function store(Request $request)
//    {
//        Rule::create($request->all());
//        return response('Rule created successfully.', 201);
//    }
//
//    /**
//     * @param Request $request
//     * @param Rule $rule
//     * @return Rule
//     */
//    public function update(Request $request, Rule $rule)
//    {
//        $rule->update($request->all());
//        return $rule;
//    }
//
//    /**
//     * @param Rule $rule
//     * @return Application|ResponseFactory|\Illuminate\Foundation\Application|Response
//     */
//    public function destroy(Rule $rule)
//    {
//        $rule->delete();
//        return response(null, 204);
//    }
}
