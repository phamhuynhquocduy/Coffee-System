<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Attribute;
use App\Models\AttributeValues;
use Session;

class FilterAttributeController extends Controller
{
    //
    public function all_attribute()
    {
        $product = Product::all();
        $attribute = Attribute::all();
        $attributevalues = AttributeValues::all();
        return view('page.product.filter', compact(['product','attribute','attributevalues']));
    }

    public function result_filter(Request $request)
    {
        $product = Product::all();
        $attribute = Attribute::all();
        $result = AttributeValues::where('id_product', $request->id_product)
                                    ->where('id_attribute', $request->id_attribute)
                                    ->get();
        return view('page.product.filter', compact(['product','attribute','result']));
    }

    public function delete_attribute($id)
    {
        AttributeValues::where('id', $id)->delete();
        Session::put('message','<p style="color:red;">Xóa thành công</p>');
        return redirect()->back();
    }
}
