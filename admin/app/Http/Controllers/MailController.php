<?php

namespace App\Http\Controllers;
use Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Session;

class MailController extends Controller
{
    // send mail
    public function send_mail()
    {
        $to_name = "Đức Trần Hoài";
        $to_email =  "duchoaikevin279@gmail.com"; // send to this mail

        $data = array(
            "name"=>"Mail từ tài khoản khách hàng",
            "body"=>"Mail gửi về vấn đề hàng hóa"
        ); // body of mail.blade.php

        Mail::send('page.send_mail', $data, function ($message) use ($to_name, $to_email) {
            $message->to($to_email)->subject('Test thử gửi mail google'); // send this mail with subject
            $message->from($to_email, $to_name); // send from this mail
        });

        return redirect('dashboard');
    }
}
