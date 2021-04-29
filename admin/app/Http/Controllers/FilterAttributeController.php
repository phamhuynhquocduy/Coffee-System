<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValues;
use Session;
use Auth;
use DB;

class FilterAttributeController extends Controller
{
    //
    public function all_attribute()
    {
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }
        $product = Product::all();
        $attribute = Attribute::all();
        $attributevalues = AttributeValues::all();
        return view('page.product.filter', compact(['product','attribute','attributevalues']));
    }

    public function result_filter(Request $request)
    {
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }
        $product = Product::all();
        $attribute = Attribute::all();
        $result = AttributeValues::where('id_product', $request->id_product)
                                    ->where('id_attribute', $request->id_attribute)
                                    ->get();
        return view('page.product.filter', compact(['product','attribute','result']));
    }

    public function delete_attribute($id)
    {
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }
        AttributeValues::where('id', $id)->delete();
        Session::put('message','<p style="color:red;">Xóa thuộc tính thành công</p>');
        return redirect()->back();
    }

    public function edit_attribute($id)
    {
        $json = AttributeValues::where('id', $id)->get();
        return response()->json($json);
    }

    public function update_attribute(Request $request)
    {
        $arr =array();
        // $arr['id_product'] = $request->id_product;
        // $arr['id_attribute'] = $request->id_attribute;
        $arr['name'] = $request->name;
        $arr['price'] = $request->price;

        DB::table('attribute_values')->where('id', $request->id)->update($arr);
        Session::put('message','<p style="color:green;">Cập nhật thuộc tính thành công</p>');
        return redirect()->back();
    }
}
