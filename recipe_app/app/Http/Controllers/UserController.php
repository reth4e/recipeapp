<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function contact() {
        return view('user.contact');
    }

    public function messages() {
        return view('user.messages');
    }

    public function message() {
        return view('user.message');
    }

    public function sendMessage() {
        //メッセージを送る
    }

    public function sendReply() {
        //返信をする
    }

    public function notifications() {
        return view('user.notifications');
    }
}
