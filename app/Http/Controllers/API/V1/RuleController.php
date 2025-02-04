<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Models\Rule;


class RuleController extends Controller
{
    public function index()
    {
        return Rule::all();
    }
}