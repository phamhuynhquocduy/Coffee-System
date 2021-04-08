<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Session;
use App\Models\Category;
use App\Models\User;
use Auth;

class DashboardController extends Controller
{
    //dashboard
    public function dashboard(){
        $category = Category::all();
        $product = Product::all();
        return view('page.dashboard', compact(['category', 'product']));
    }

    public function login(){
        return view('login');
    }

    // public function post_login(Request $request){
    //     $arr = [
    //         'name' => $request->username,
    //         'password' => md5($request->password)
    //     ];

    //     return response()->json($arr);

    //     if(Auth::guard('web')->attempt($arr)){
    //         return view('page.dashboard');
    //     }
    //     else{
    //         Session::put('message','<p style="color: red;>Tài khoản hoặc mật khẩu sai, vui lòng đăng nhập lại!!!</p>');
    //         return redirect('login');
    //     }
    // }

    // public function view_admin(){
    //     return response()->json(User::all());
    // }
}
