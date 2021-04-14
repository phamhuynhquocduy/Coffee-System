<?php

namespace App\Http\Controllers;

use Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Session;
use App\Models\Customer;

class ResetPasswordApiController extends Controller
{
    //
    public function send_email_api(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $check_email = Customer::where('email', $request->email)->first();
        if(empty($check_email)){
            return response()->json(['message', 'Email chưa đăng ký']);
        }
        
        $user = Customer::where('email', $request->email)->first();
        $tokenResult = $user->createToken('authToken')->plainTextToken;

        $to_name = "Đức Trần Hoài";
        $to_email =  "521d6651b4-1d6551@inbox.mailtrap.io"; // send to this mail

        $data = array(
            "name"=>"Mail từ tài khoản khách hàng",
            "body"=>"Mail gửi về vấn đề hàng hóa",
            "_token" => $tokenResult
        );
        // gửi mail chứa link token -> new password layout
        Mail::send('page.send_mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject('Test thử gửi mail google'); // send this mail with subject
            $message->from($to_email, $to_name); // send from this mail
        });
    }

    public function reset_password_api(){
        
    }
}
