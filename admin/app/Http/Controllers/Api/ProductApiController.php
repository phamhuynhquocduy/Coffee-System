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
    // public function filter_product(Request $request)
    // {
    //     // xử lý filter
    //     $name = $request->has('name') ? $request->name : null;
        
    //     $id_category = $request->has('id_category') ? $request->id_category : null;

    //     $min = $request->has('min_price') ? $request->min_price : 0;
    //     $max = $request->has('max_price') ? $request->max_price : 9000000;

    //     if($name==null&&$id_category!=null)
    //     {
    //         $product = DB::table('products')
    //         ->where('id_category', $id_category)
    //         ->where('price','>=',$min)
    //         ->where('price','<=',$max)
    //         ->orderBy('price','ASC')
    //         ->get();
    //     }
    //     else if($id_category==null&&$name!=null)
    //     {
    //         $product = DB::table('products')
    //         ->where('name','like','%'.$name.'%')
    //         ->where('price','>=',$min)
    //         ->where('price','<=',$max)
    //         ->orderBy('price','ASC')
    //         ->get();
    //     }
    //     else if($id_category==null&&$name==null)
    //     {
    //         $product = Product::
    //         where('price','>=',$min)
    //         ->where('price','<=',$max)
    //         ->orderBy('price','ASC')
    //         ->get();
    //     }
    //     else
    //     {
    //         $product = DB::table('products')
    //         ->where('name','like','%'.$name.'%')
    //         ->where('id_category', $id_category)
    //         ->where('price','>=',$min)
    //         ->where('price','<=',$max)
    //         ->orderBy('price','ASC')
    //         ->get();
    //     }

    //     // return response()->json($product);

    //     $attribute = Attribute::all();

    //     $attribute_values = AttributeValues::all();
    //     $arrrr = array();
    //     foreach($product as $key)
    //     {
    //         $arr = array();
    //         $arr['id'] = $key->id;
    //         $arr['name'] = $key->name;
    //         $arr['description'] = $key->description;
    //         $arr['image'] = $key->image;
    //         $arr['price'] = $key->price;
    //         $arr['id_category'] = $key->id_category;
    //         $arr['status'] = $key->status;
    //         $arr['attributes'] = [
    //             [
    //                 //topping
    //                 'id' => $attribute[0]->id,
    //                 'name' => $attribute[0]->name,
    //                 'values' => AttributeValues::where('id_attribute', $attribute[0]->id)
    //                                             ->where('id_product',$key->id)
    //                                             ->get(['id','name','price'])
    //             ],
    //             [
    //                 //size
    //                 'id' => $attribute[1]->id,
    //                 'name' => $attribute[1]->name,
    //                 'values' => AttributeValues::where('id_attribute', $attribute[1]->id)
    //                                                 ->where('id_product',$key->id)
    //                                                 ->get(['id','name','price'])
    //             ]
    //         ];

    //         $arrrr[] = $arr;
    //     }
    //     return response()->json($arrrr);
    // }

    /* ---------------- FILTER -------------------- */
    public function filter(Request $request)
    {
        // xử lý request
        $name = $request->has('name') ? $request->name : null;
        $id_category = $request->has('id_category') ? $request->id_category : null;
        $min = $request->has('min_price') ? $request->min_price : null;
        $max = $request->has('max_price') ? $request->max_price : null;

        $product = Product::with('attrs');

        if($name != null)
        {
            $result = $product->where('name','like','%'.$name.'%');
        }
        if($id_category != null)
        {
            $result = $product->where('id_category', $id_category);
        }
        if($min != null && $max == null)
        {
            $result = $product->where('price', '>=',$min);
        }
        if($min == null && $max != null)
        {
            $result = $product->where('price', '<=',$max);
        }
        if($min != null && $max != null)
        {
            $result = $product->whereBetween('price', [$min, $max]);
        }
        $result = $product->orderBy('price', 'asc')->get();

        return response()->json($result);
    }
}
