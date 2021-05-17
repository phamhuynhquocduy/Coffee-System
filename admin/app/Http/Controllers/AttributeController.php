<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
    //
    public function index()
    {
        $all = Attribute::all();

        return view('page.attribute.all', compact(['all']));
    }

    public function delete($id)
    {
        $attribute_del = Attribute::find($id);

        $attribute_del->delete();

        return redirect()->back()->with('message', '<p style="color: red;">Xóa thuộc tính sản phẩm thành công!</p>');
    }

    public function update(Request $request, $id)
    {
        
    }
}
