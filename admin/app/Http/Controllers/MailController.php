<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use DB;
use Hash;

class MailController extends Controller
{
    // get send mail
    public function get_send_mail(){
        return view('login.password_reset');
    }
    // post send mail
    public function post_send_mail(Request $request)
    {
        // check mail in data
        $check_mail = User::where('email', $request->email)->first();
        if(empty($check_mail)){
            return redirect('send-mail')->with(['message' => '<p style="color: red;">Email chưa đăng ký</p>']);
        }
        $tokenResult = $check_mail->createToken('authToken')->plainTextToken;
        $to_name = "Đức Trần Hoài";
        $to_email =  "521d6651b4-1d6551@inbox.mailtrap.io"; // send to this mail
        $send_email = $request->email;

        $mail = DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $tokenResult
        ]);

        $data = array(
            "name"=>"Mail từ Admin",
            "body"=>"Mail gửi về vấn đề đổi mật khẩu",
            "token" => $tokenResult,
        ); // body of mail.blade.php

        Mail::send('page.send_mail', $data, function ($message) use ($to_name, $to_email, $send_email) {
            $message->to($send_email)->subject('Đổi mật khẩu'); // send this mail with subject
            $message->from($to_email, $to_name); // send from this mail
        });

        return redirect('send-mail-admin')->with(['message' => '<p style="color: green;">Đã gửi xác nhận tới email</p>']);
    }

    // reset password admin
    public function get_reset_password_admin($token)
    {
        $reset_admin = DB::table('password_resets')->where('token', $token)->get();
        return view('page.r_password_admin')->with(['reset_admin' => $reset_admin]);
    }

    public function post_reset_password_admin(Request $request, $token)
    {
        $request->validate([
            'password' => 'required|min:6'
        ]);

        if($request->password != $request->re_password){
            return redirect()->back()->with('message','<p style="color:red;">Đổi mật khẩu không thành công, vui lòng quay lại trang và kiểm tra lại mật khẩu</p>');
        }
        $email = DB::table('password_resets')->where('token', $token)->get();

        User::where('email', $email[0]->email)->update(['password'=>Hash::make($request->password)]);
        // $token = '';
        DB::table('password_resets')->where('email', $email[0]->email)->update(['token' => '']);
        return redirect('login')->with('message','<p style="color:green;">Đổi mật khẩu thành công</p>');
    }
}
