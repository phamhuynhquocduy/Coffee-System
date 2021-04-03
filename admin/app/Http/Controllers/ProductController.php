<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
session_start();

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list_cate = Category::all();
        $list_product = Product::all();
        return view('page.product.all', compact(['list_cate', 'list_product']));
    }
    // convert json product
    public function conver_product_json(){
        $product = Product::all();
        return response()->json($product);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $list_cate = Category::all();
        return view('page.product.create', compact(['list_cate']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $image = $request->file('inputImage');
        $image->move('public/save/images/product',  $image->getClientOriginalName());
        $like = Product::where('name', $request->inputName)->get();
        if(!empty($like[0]->name)){
            Session::put('message', '<p style="color:red;">Sản phẩm đã tồn tại, vui lòng nhập sản phẩm khác!!</p>');
            return redirect('product/create');
        }
        $arr = array();
        $arr['name'] = $request->inputName;
        $arr['description'] = $request->inputDescription;
        $arr['image'] = $image->getClientOriginalName();
        $arr['price'] = $request->inputPrice;
        $arr['id_category'] = $request->inputCategory;
        $arr['status'] = $request->inputStatus;

        $test = Product::insert($arr);
        Session::put('message', '<p style="color:green;">Thêm sản phẩm thành công</p>');
        return redirect('product/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // 
        $info_pro = Product::where('id', $id)->get();
        return view('page.product.view',compact(['info_pro']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $list_cate = Category::all();
        $edit_pro = Product::where('id', $id)->get();
        return view('page.product.edit', compact(['list_cate','edit_pro']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $image = $request->file('inputImage');
        $image->move('public/save/images/product',  $image->getClientOriginalName());
        $like = Product::where('name', $request->inputName)->get();

        Product::where('id',$id)->update([
            'name' => $request->inputName,
            'description' => $request->inputDescription,
            'image' => $image->getClientOriginalName(),
            'price' => $request->inputPrice,
            'id_category' => $request->inputCategory,
            'status' => $request->inputStatus
        ]);
        Session::put('message', '<p style="color:green;">Thêm sản phẩm thành công</p>');
        return redirect('product');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $del_img = Product::where('id',$id)->get('image');
        Storage::delete('public/save/images/product/'+$del_img[0]->image);
        Product::where('id',$id)->delete();
        Session::put('message', '<p style="color:red;">Xóa sản phẩm thành công</p>');
        return redirect('product');
    }
}
