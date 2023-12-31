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

    public function testSendReply() //sendReplyのテスト
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

        $response = $this->post(route('reply', [ //返信する
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

        $this -> actingAs($login_user);

        $data = [
            'title' => 'sampletitle',
            'content' => 'samplemessage',
        ];
        $response = $this->post('/message' ,$data);
        $response = $this->get('/list_messages')->assertSee("sampletitle"); //投稿したメッセージのタイトルが表示されているか確認
    }

    public function testMessage() //messageのテスト
    {
        $login_user = User::factory() -> create();
        $this -> actingAs($login_user);

        $data = [
            'title' => 'sampletitle',
            'content' => 'samplemessage',
        ];
        $response = $this->post('/message' ,$data);
        $message = Message::latest()->first();

        $response = $this->get(route('message', [ //メッセージ個別ページ
            'message_id' => $message->id,
        ]))->assertSee("samplemessage");

        $response->assertSee("sampletitle"); //タイトルとメッセージ内容が表示されているか確認
    }

    public function testNotifications() //notificationsのテスト
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

        $this->actingAs($admin_user); //管理者でログインしてユーザーからの通知が表示されるか確認
        $response = $this->get('/notifications')->assertSee($login_user->name.'様からお問い合わせがありました。');

        $message = Message::latest()->first();
        $response = $this->post(route('reply', [ //返信する
            'message_id' => $message->id,
            'content' => 'samplereply',
        ]));

        $this -> actingAs($login_user); //管理者からの返信の通知が表示されるか確認
        $response = $this->get('/notifications')->assertDontSee($login_user->name.'様からお問い合わせがありました。');
        $response = $this->get('/notifications')->assertSee('管理者から返信がありました。');
    }

    public function testRead() //readのテスト
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

        $this->actingAs($admin_user);

        $message = Message::latest()->first();
        $response = $this->post(route('reply', [ //返信する
            'message_id' => $message->id,
            'content' => 'samplereply',
        ]));

        $this->actingAs($login_user);
        $this -> assertDatabaseHas('notifications', [ //通知が未読であることを確認
            'read_at' => NULL,
        ]);

        $response = $this->get(route('read', [
            'notification_id' => $login_user -> unreadNotifications() -> first() -> id,
        ]));

        $this -> assertDatabaseMissing('notifications', [ //通知が既読化されているか確認
            'read_at' => NULL,
        ]);
    }
}
