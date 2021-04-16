<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Customer;

class ProfileCustomerController extends Controller
{
    //
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'address' => 'required'
        ]);

        $user = $request->user();

        $user->update($request->only('name', 'address'));

        return response()->json($user);
    }

    public function update_password(Request $request)
    {
        // $request->validate([
        //     'password' => 'required'
        // ]);
        $user = $request->user();

        $check_password_old = Hash::make($request->old_password);

        // if(empty($check_password_old)){
        //     return 'Mật khẩu cũ sai, vui lòng kiểm tra lại!'; 
        // }

        // if($request->password != $request->re_password){
        //     return 'Lỗi không đúng mật khẩu';
        // }

        // $new_password = Hash::make($request->password);
        // $user->update(['password'=>$new_password]);

        // return response()->json($user);
        return response()->json(["pass"=>$check_password_old, "user" => $user]);
    }
}
