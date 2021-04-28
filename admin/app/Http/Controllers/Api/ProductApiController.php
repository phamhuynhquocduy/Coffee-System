<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\AttributeValues;
use App\Models\Attribute;
use DB;

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

    public function filter_product(Request $request)
    {
        // xử lý filter
        $name = $request->has('name') ? $request->name : null;
        
        $category = $request->has('category') ? $request->category : null;
        if($category == null)
        {
            $id_category = null;
        }
        else
        {
            $id_category = Category::where('name', 'like', '%'.$category.'%')->first();
        }

        $min = $request->has('min_price') ? $request->min_price : 0;
        $max = $request->has('max_price') ? $request->max_price : 9000000;

        if($name==null&&$id_category!=null)
        {
            $product = DB::table('products')
            ->where('id_category', $id_category)
            ->where('price','>=',$min)
            ->where('price','<=',$max)
            ->orderBy('price','ASC')
            ->get();
        }
        else if($id_category==null&&$name!=null)
        {
            $product = DB::table('products')
            ->where('name','like',$name)
            ->where('price','>=',$min)
            ->where('price','<=',$max)
            ->orderBy('price','ASC')
            ->get();
        }
        else if($id_category==null&&$name==null)
        {
            $product = Product::
            where('price','>=',$min)
            ->where('price','<=',$max)
            ->orderBy('price','ASC')
            ->get();
        }
        else
        {
            $product = DB::table('products')
            ->where('name','like',$name)
            ->where('id_category', $id_category)
            ->where('price','>=',$min)
            ->where('price','<=',$max)
            ->orderBy('price','ASC')
            ->get();
        }

        // return response()->json($product);

        $attribute = Attribute::all();

        $attribute_values = AttributeValues::all();

        foreach($product as $key)
        {
            $arr = array();
            $arr['id'] = $key->id;
            $arr['name'] = $key->name;
            $arr['description'] = $key->description;
            $arr['image'] = $key->image;
            $arr['price'] = $key->price;
            $arr['id_category'] = $key->id_category;
            $arr['status'] = $key->status;
            $arr['attributes'] = [
                [
                    //topping
                    'id' => $attribute[0]->id,
                    'name' => $attribute[0]->name,
                    'values' => AttributeValues::where('id_attribute', $attribute[0]->id)
                                                ->where('id_product',$key->id)
                                                ->get(['id','name','price'])
                ],
                [
                    //size
                    'id' => $attribute[1]->id,
                    'name' => $attribute[1]->name,
                    'values' => AttributeValues::where('id_attribute', $attribute[1]->id)->get(['id','name','price'])
                ]
            ];

            echo json_encode($arr);
        }
    }
}
