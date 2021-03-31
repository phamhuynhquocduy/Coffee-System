<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Session;
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
        $arr = array([
            'name' => $request->inputName,
            'description' => $request->inputDescription,
            'image' => $image->getClientOriginalName()
        ]);

        Category::insert($arr);
        Session::put('message', '<p style="color: green;">Thêm sản phẩm thành công</p>');
        return view('page.category.create');
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
    public function show(Category $category)
    {
        //
        return view('page.category.view');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return view('page.category.edit');
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
        Session::put('message', '<p style="color:red;">Xóa sản phẩm thành công</p>');
        echo 'xóa thành công';
    }
}
