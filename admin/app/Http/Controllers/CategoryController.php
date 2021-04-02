<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
session_start();

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $category = Category::all();
        return view('page.category.all',compact(['category']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('page.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *///Save product method post
    public function store(Request $request)
    {
        //
        $image = $request->file('inputImage');
        $image->move('public/save/images', $image->getClientOriginalName());
        $like = Category::where('name', $request->inputName)->get();
        if(!empty($like[0]->name)){
            Session::put('message', '<p style="color:red;">Danh mục sản phẩm đã tồn tại, vui lòng nhập danh mục khác!!</p>');
            return redirect('category/create');
        }
        $arr = array([
            'name' => $request->inputName,
            'description' => $request->inputDescription,
            'image' => $image->getClientOriginalName()
        ]);

        Category::insert($arr);
        Session::put('message', '<p style="color: green;">Thêm danh mục sản phẩm thành công</p>');
        return redirect('category/create');
    }
    //trả dữ liệu ra json
    public function conver_category_json(){
        $json_category = Category::all();
        return response()->json($json_category);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $info_cate = Category::where('id', $id)->get();

        return view('page.category.view', compact(['info_cate']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $edit_cate = Category::where('id', $id)->get();
        return view('page.category.edit', compact(['edit_cate']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $image = $request->file('inputImage');
        $image->move('public/save/images', $image->getClientOriginalName());
        $arr = array([
            'name' => $request->inputName,
            'description' => $request->inputDescription,
            'image' => $image->getClientOriginalName()
        ]);

        Category::insert($arr);
        Session::put('message', '<p style="color: green;">Cập nhật danh mục sản phẩm thành công</p>');
        return redirect('category');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        Category::where('id', $id)->delete();
        Session::put('message', '<p style="color:red;">Xóa danh mục sản phẩm thành công</p>');
        return redirect('category');
    }
}
