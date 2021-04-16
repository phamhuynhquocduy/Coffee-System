<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;
use Auth;

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
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }
        $category = Category::paginate(10);
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
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }
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
        // check name
        $like = Category::where('name', $request->inputName)->get();
        if(!empty($like[0]->name)){
            Session::put('message', '<p style="color:red;">Danh mục sản phẩm đã tồn tại, vui lòng nhập danh mục khác!!</p>');
            return redirect('category/create');
        }
        // check image
        if($request->hasFile('inputImage')){
            $image = $request->file('inputImage');
            $name_image = rand(0,200).$image->getClientOriginalName();
            $image->move('public/save/images/category/',  $name_image);   
        }
        
        $arr = array([
            'name' => $request->inputName,
            'description' => $request->inputDescription,
            'image' => 'public/save/images/category/'.$name_image
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
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }
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
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }
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
    public function update(Request $request, $id)
    {
        //
        $arr = array();
        $image = $request->file('inputImage');
        if($image){
            $name_image = rand(0,200).$image->getClientOriginalName();
            $image->move('public/save/images/category/',  $name_image);
            $arr['image'] = 'public/save/images/category/'.$name_image;
            Category::where('id', $id)->update($arr);
        }
        $like = Category::where('name', $request->inputName)->get();
        if(!empty($like[0]->name)){
            Session::put('message', '<p style="color:red;">Danh mục sản phẩm đã tồn tại, vui lòng nhập danh mục khác!!</p>');
            return redirect('category');
        }
        Category::where('id', $id)->update([
            'name' => $request->inputName,
            'description' => $request->inputDescription,
        ]);
        
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
        if(empty(Auth::check())){
            Session::put('message', '<p style="color: red;">Bạn cần phải đăng nhập</p>');
            return view('login');
        }
        Category::where('id', $id)->delete();
        Session::put('message', '<p style="color:red;">Xóa danh mục sản phẩm thành công</p>');
        return redirect('category');
    }
}
