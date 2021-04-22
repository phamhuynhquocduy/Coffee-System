<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductApiController extends Controller
{
    //
    public function filter_attribute($id){
        $category_profile = Category::where('id', $id)->get();
        
        if(empty($category_profile[0]->id)){
            return 'Không có kết quả trả về';
        } 
        
        $all_product_category_profile = Product::where('id_category', $id)->get();

        return response()->json([
            'id' => $category_profile[0]->id,
            'name' => $category_profile[0]->name,
            'description' => $category_profile[0]->description,
            'image' => $category_profile[0]->image,
            'product' => $all_product_category_profile
        ]);
    }
}
