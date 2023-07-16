<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Reply;
use App\Notifications\PictureNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\MessageRequest;

class UserController extends Controller
{
    public function contact() { //お問い合わせページ
        $login_user = Auth::User();
        return view('user.contact');
    }

    public function messages() { //メッセージリストページ
        $login_user = Auth::User();
        $messages = Message::where('user_id',$login_user->id)->get();
        return view('user.messages',compact('messages'));
    }

    public function message(Request $request) { //メッセージ個別ページ
        $login_user = Auth::User();
        $message = Message::find($request->message_id)->where('user_id',$login_user->id)->first();
        return view('user.message',compact('message'));
    }

    public function sendMessage(MessageRequest $request) { //メッセージを送る
        $login_user = Auth::User();

        $message = new Message();
        $message -> user_id = $login_user->id;
        $message -> title = $request -> title;
        $message -> content = $request -> content;
        $message -> save();

        $request->session()->regenerateToken();

        return view('user.messages');
    }

    public function sendReply() { //返信をする
        return view('user.messages');
    }

    public function notifications() { //通知ページ
        return view('user.notifications');
    }
}
