<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Session;
use App\Models\Customer;
use DB;

class ResetPasswordApiController extends Controller
{
    public function send_email_api(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $check_email = Customer::where('email', $request->email)->first();
        if(empty($check_email)){
            return response()->json(['message', 'Email chưa đăng ký']);
        }
        
        $tokenResult = $check_email->createToken('authToken')->plainTextToken;
        
        $email = DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $tokenResult
        ]);

        $to_name = "Đức Trần Hoài";
        $to_email =  "521d6651b4-1d6551@inbox.mailtrap.io"; // send to this mail

        $data = array(
            "name"=>"Mail từ tài khoản khách hàng",
            "body"=>"Mail gửi về vấn đề hàng hóa",
            "token" => $tokenResult,
        );
        // gửi mail chứa link token -> new password layout
        Mail::send('page.send_mail_api', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject('Test thử gửi mail google'); // send this mail with subject
            $message->from($to_email, $to_name); // send from this mail
        });

        return response()->json([
            "message" => "Gửi mail thành công",
            "token" => $tokenResult,  
            "email" => $email,
        ]);
    }

    public function reset_password_api($token){
        $reset = DB::table('password_resets')->where('token', $token)->get();
        return view('page.reset_password')->with(['reset' => $reset]);
    }

    public function post_reset_password(Request $request, $token){
        $request->validate([
            'password' => 'required|min:6'
        ]);

        if($request->password != $request->re_password){
            return redirect()->back()->with(['message' => 'Vui lòng kiểm tra lại mật khẩu']);
        }
        $email = DB::table('password_resets')->get();

        Customer::where('email', $email[0]->email)->update(['password' => $request->password]);
        $token = '';
        DB::table('password_resets')->where('email', $email[0]->email)->delete('token');
        return response()->json(['message' => 'Đổi mật khẩu thành công']);
    }

    public function check_reset_passwords(){
        $email = DB::table('password_resets')->get();
        return response()->json(["email" => $email[0]->email]);
    }
}
