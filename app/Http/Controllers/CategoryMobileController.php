<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoryMobileController extends Controller
{
    public function get(){
        $category =  Category::select("id","name")->get();

        return response()->json([
            "data" => $category
        ]);
    }
}
