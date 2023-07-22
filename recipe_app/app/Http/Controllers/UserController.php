<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Reply;
use App\Notifications\MessageNotification;
use App\Notifications\ReplyNotification;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\MessageRequest;

class UserController extends Controller
{
    public function contact() { //お問い合わせページ
        $login_user = Auth::User();
        if ($login_user -> is_admin) {
            session()->flash('status', '管理者はこの機能を利用できません');
            return back();
        }
        return view('user.contact');
    }

    public function messages() { //メッセージリストページ
        $login_user = Auth::User();
        $messages = Message::where('user_id',$login_user->id)->orderBy('created_at','DESC')->paginate(20);

        if($login_user->is_admin){
            $messages = Message::orderBy('created_at','DESC')->paginate(20);
        }
        return view('user.messages',compact('messages'));
    }

    public function message(Request $request) { //メッセージ個別ページ
        $login_user = Auth::User();

        $message = Message::where('id',$request->message_id)->where('user_id',$login_user->id)->first();
        if($login_user->is_admin){
            $message = Message::where('id',$request->message_id)->first();
        }
        $replies = Reply::where('message_id',$message->id)->orderBy('created_at','DESC')->paginate(20);

        $data = [
            'message' => $message,
            'replies' => $replies,
        ];
        return view('user.message',$data);
    }

    public function sendMessage(MessageRequest $request) { //メッセージを送る
        $login_user = Auth::User();

        $message = new Message();
        $message -> user_id = $login_user->id;
        $message -> title = $request -> title;
        $message -> content = $request -> content;
        $message -> save();

        $request->session()->regenerateToken();

        $admin = User::where('is_admin',1) -> get();
        Notification::send($admin, new MessageNotification($message));

        $messages = Message::where('user_id',$login_user->id)->orderBy('created_at','DESC')->paginate(20);
        session()->flash('status', 'メッセージ送信しました');

        return view('user.messages',compact('messages'));
    }

    public function sendReply(MessageRequest $request) { //返信をする
        $login_user = Auth::User();

        $reply = new Reply();
        $reply -> user_id = $login_user -> id;
        $reply -> message_id = $request -> message_id;
        $reply -> content = $request -> content;
        $reply -> save();

        $notification_m = $login_user -> notifications() -> where('data->id',$request -> message_id) -> get();
        $notification_m -> markAsRead(); //メッセージに関する通知を既読化

        $request->session()->regenerateToken();

        if($login_user->is_admin) {
            $message = Message::where('id',$request->message_id)->first();
            $user = $message -> user;
            Notification::send($user, new ReplyNotification($reply));
        } else {
            $message = Message::where('id',$request->message_id)->where('user_id',$login_user->id)->first();
            $admin = User::where('is_admin',1)->get();
            Notification::send($admin, new ReplyNotification($reply));
        }

        session()->flash('status', '返信しました');
        return back();
    }

    public function notifications() { //通知ページ
        $login_user = Auth::User();
        $notifications = $login_user -> unreadNotifications() -> paginate(10);
        return view('user.notifications',compact('notifications'));
    }

    public function read (Request $request) {
        // 1件の未読通知を既読化（一般ユーザーのみ）
        $login_user = Auth::user();
        if($login_user->is_admin) {
            session()->flash('status', '管理者はこの機能を利用できません');
            return back();
        }

        $notification = $login_user -> notifications() -> find($request -> notification_id);
        $notification -> markAsRead();
        session()->flash('status', '既読化しました');

        return back();
    }
}
