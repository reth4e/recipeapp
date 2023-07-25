<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Message;
use App\Models\Reply;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MessageNotification;
use App\Notifications\ReplyNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{ //UserControllerのテスト
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use DatabaseTransactions;
    public function testContact() //contactのテスト
    {
        $login_user = User::factory() -> create();
        $this -> actingAs($login_user);

        $response = $this->get('/contact');
        $response->assertStatus(200);

        $login_user->is_admin = 1; //管理者にする
        $login_user->save();

        $response = $this->get('/contact');
        $response->assertStatus(302);
    }

    public function testSendMessage() //sendMessageのテスト
    {
        $login_user = User::factory() -> create();
        $admin_user = User::factory() -> create();
        $admin_user->is_admin = 1; //管理者にする
        $admin_user->save();
        $this -> actingAs($login_user);

        $data = [
            'title' => 'sampletitle',
            'content' => 'samplemessage',
        ];

        Notification::fake(); //通知が実際に送信されないようにする

        $response = $this->post('/message' ,$data);
        $response->assertStatus(200);

        $this -> assertDatabaseHas('messages', [ //メッセージが保存されているか確認
            'user_id' => $login_user->id,
            'title' => 'sampletitle',
            'content' => 'samplemessage',
        ]);

        //管理者にお問い合わせの通知が届いたことの確認
        Notification::assertSentTo($admin_user, MessageNotification::class);
    }

    public function testSendReply() //sendMessageのテスト
    { 
        $login_user = User::factory() -> create();
        $admin_user = User::factory() -> create();
        $admin_user->is_admin = 1; //管理者にする
        $admin_user->save();
        $this -> actingAs($login_user);

        $data = [
            'title' => 'sampletitle',
            'content' => 'samplemessage',
        ];

        $response = $this->post('/message' ,$data);

        $message = Message::latest()->first();

        Notification::fake(); //通知が実際に送信されないようにする

        $response = $this->post(route('reply', [ //お気に入り登録
            'message_id' => $message->id,
            'content' => 'samplereply',
        ]));

        $this -> assertDatabaseHas('replies', [ //メッセージが保存されているか確認
            'message_id' => $message->id,
            'user_id' => $login_user->id,
            'content' => 'samplereply',
        ]);

        //管理者に返信に関する通知が届いたことの確認
        Notification::assertSentTo($admin_user, ReplyNotification::class);
    }

    public function testMessages() //messagesのテスト
    {
        $login_user = User::factory() -> create();
    }
}
