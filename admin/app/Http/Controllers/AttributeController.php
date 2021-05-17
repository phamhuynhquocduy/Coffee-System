<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attribute;

class AttributeController extends Controller
{
    //
    public function set_attr()
    {
        return view('page.attribute.create');
    }

    public function get_attr(Request $request)
    {
        Attribute::create($request->only('name_attr'));

        return redirect()->back()->with('message','<p style="color:green;">Thêm thuộc tính thành công</p>');
    }

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

    public function edit($id)
    {
        $edit_attr = Attribute::where('id', $id)->get();

        return view('page.attribute.edit', compact(['edit_attr']));
    }

    public function update(Request $request, $id)
    {
        $update_attr = Attribute::where('id', $id);

        $update = $update_attr->update(['name_attr'=>$request->name_attr]);

        return redirect('attribute/index')->with('message', '<p style="color: green;">Cập nhật thuộc tính thành công</p>');
    }
}
