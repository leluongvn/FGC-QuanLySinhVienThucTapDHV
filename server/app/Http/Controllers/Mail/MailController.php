<?php

namespace App\Http\Controllers\Mail;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{

    public function sendMail(Request $request){
        $data['gui'] = $request->all();
        $mail = $request->email;
        Mail::send('sendmail',$data, function ($message) use ($mail) {
            $message->from('datletien2017@gmail.com', 'Admin');
            $message->to($mail, $mail);
            // $message->cc('letiendat27297@gmail.com', 'dat le');
            $message->subject('Thông tin tài khoản & mật khẩu');
        });
        return response()->json($data['gui'],404);

    }

}