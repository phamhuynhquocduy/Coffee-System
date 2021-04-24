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

    public function filter_price(Request $request)
    {
        if($request->price)
        {
            $price = $request->price;
            switch($price)
            {
                case '1':
                    $products = Product::where('price','<',10000);
                    break;
                case '2': 
                    $products = Product::whereBetween('price',[10000,30000]);
                    break;
                case '3': 
                    $products = Product::whereBetween('price',[30000,50000]);
                    break;
                case '4': 
                    $products = Product::whereBetween('price',[50000,70000]);
                    break;
                case '5': 
                    $products = Product::where('price','>',70000);
                    break;
            }
        }

        $products = $products->orderBy('price','ASC')->get();

        return response()->json($products);
    }
}
