<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;
use Mail;

class CustomerApiController extends Controller
{
    //register
    public function register(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required',
        ]);
        
        $check_username = Customer::where('username', $request->username)->first();
        $check_email = Customer::where('email', $request->email)->first();
        $check_phone = Customer::where('phone', $request->phone)->first();
        
        if(!empty($check_username)){
            return 'Tài khoản đã đăng ký!';
        }
        if(!empty($check_email)){
            return 'Email đã đăng ký!';
        }
        if(!empty($check_phone)){
            return 'Số điện thoai đã đăng ký!';
        }

        Customer::create([
            'name' => $request->input('name'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address')
        ]);

        // return response()->noContent();
        return 'Success!';
    }

    //user
    public function user(Request $request){
        return response()->json($request->user());
    }

    //login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $credentials = request(['username', 'password']);

        if (!Auth::guard('customer')->attempt($credentials)) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Unauthorized'
            ]);
        }

        $user = Customer::where('username', $request->username)->first();

        $tokenResult = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'status_code' => 200,
            'access_token' => $tokenResult,
            'user' => $user,
        ]);
    }  
    //logout
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->currentAccessToken()->delete();
        return response()->json([
            'message' => 'Success',
        ]);
    } 
}
