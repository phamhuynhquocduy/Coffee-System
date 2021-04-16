<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Session;
use App\Models\Customer;
use DB;
use Hash;

class ResetPasswordApiController extends Controller
{
    //get send mail api
    public function get_send_email_api(){
        return view('login.password_reset_api');
    }
    //post send mail api
    public function send_email_api(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $check_email = Customer::where('email', $request->email)->first();
        if(empty($check_email)){
            return 'Vui lòng quay lại trang và kiểm tra lại email';
        }
        
        $tokenResult = $check_email->createToken('authToken')->plainTextToken;
        
        $email = DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $tokenResult
        ]);

        $to_name = "Đức Trần Hoài";
        $to_email =  "521d6651b4-1d6551@inbox.mailtrap.io"; // send to this mail

        $mail_c = $request->email;

        $data = array(
            "name"=>"Amin",
            "body"=>"Mail gửi về vấn đề đổi mật khẩu",
            "token" => $tokenResult,
        );
        // gửi mail chứa link token -> new password layout
        Mail::send('page.send_mail_api', $data, function ($message) use ($to_name, $to_email, $mail_c) {
            $message->to($mail_c)->subject('Test thử gửi mail google'); // send this mail with subject
            $message->from($to_email, $to_name); // send from this mail
        });
        return 'Gửi mail thành công, vui lòng kiểm tra email';
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
            return redirect()->back()->with(['message' => 'Vui lòng kiểm tra lại mật khẩu!']);
        }
        $email = DB::table('password_resets')->get();

        Customer::where('email', $email[0]->email)->update(['password' => Hash::make($request->password)]);
        // $token = '';
        DB::table('password_resets')->where('email', $email[0]->email)->update(['token' => '']);
        return 'Đổi mật khẩu thành công';
    }

    public function check_reset_passwords(){
        $email = DB::table('password_resets')->get();
        return response()->json($email);
    }
}
