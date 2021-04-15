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
        
        $check = Customer::where('username', $request->username)
                            ->orWhere('email', $request->email)
                            ->orWhere('phone', $request->phone)->first();
        
        if(!empty($check)){
            // return response()->json([
            //     'message' => 'Tài khoản đã tồn tại'
            // ]);
            return 'Tài khoản đã tồn tại!';
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
