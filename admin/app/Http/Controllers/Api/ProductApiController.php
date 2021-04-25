<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductApiController extends Controller
{
    //
    public function filter_attribute(){
        $category_profile = Category::all();

        foreach($category_profile as $key)
        {
            $arr = array();
            $arr['id'] = $key->id;
            $arr['name'] = $key->name;
            $arr['description'] = $key->description;
            $arr['image'] = $key->image;
            $arr['product'] = Product::where('id_category', $key->id)->get();

            echo json_encode($arr);
        }
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
