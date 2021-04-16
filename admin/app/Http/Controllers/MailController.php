<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Session;
use App\Models\User;

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

        $to_name = "Đức Trần Hoài";
        $to_email =  "521d6651b4-1d6551@inbox.mailtrap.io"; // send to this mail
        $send_email = $request->email;

        $data = array(
            "name"=>"Mail từ Admin",
            "body"=>"Mail gửi về vấn đề đổi mật khẩu"
        ); // body of mail.blade.php

        Mail::send('page.send_mail', $data, function ($message) use ($to_name, $to_email, $send_email) {
            $message->to($send_email)->subject('Test thử gửi mail google'); // send this mail with subject
            $message->from($to_email, $to_name); // send from this mail
        });

        return redirect('send-mail')->with(['message' => '<p style="color: green;">Đã gửi xác nhận tới email</p>']);
    }
}
