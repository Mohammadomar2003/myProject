<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function showCategoryMedicines($id)
    {
        $medicines=Category::find($id)->getMedicines;
        $array=[
            'data'=>$medicines,
            'msg'=>'ok',
            'status'=>200
        ];
        return response($array);
    }
    public function getCategory()
    {
        $category=Category::all();

        $array=[
            'data'=>$category,
            'message'=>'all warehouse',
            'status'=>200
        ];
        return response($array);
    }
}
