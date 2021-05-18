<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Session;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Attribute;
use App\Models\User;
use Auth;
use Hash;

class DashboardController extends Controller
{
    //dashboard
    public function dashboard(){
        if(Auth::check()){
            $category = Category::all();
            $product = Product::all();
            $customer = Customer::all();
            $attribute = Attribute::all();
            return view('page.dashboard', compact(['category', 'product', 'customer', 'attribute']));
        }
        else{
            Session::put('message', '<p style="color:red;">Bạn cần phải đăng nhập</p>');
            return redirect('login');
        }
    }

    public function login(){
        return view('login');
    }

    public function post_login(Request $request){
        $arr = [
            'name' => $request->username,
            'password' => $request->password
        ];

        // return response()->json($arr);

        if(Auth::guard('web')->attempt($arr)){
            return redirect('dashboard');
        }
        else{
            Session::put('message','<p style="color: red;">Tài khoản hoặc mật khẩu sai, vui lòng đăng nhập lại!!!</p>');
            return redirect('login');
        }
    }

    public function view_admin(){
        return response()->json(User::all());
    }
    //logout
    public function logout(){
        Auth::logout();
        return redirect('login');
    }
}
