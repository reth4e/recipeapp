@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        <div class="message-block">
            <p class="mb-5 fs-2">タイトル：{{$message->title}}</p>
            <p class="mb-5 fs-1">ユーザー名:{{$message->user->name}}, 投稿日：{{$message->created_at}}</p>
            <p class="mb-5 fs-1">お問い合わせ内容：{{$message->content}}</p>
        </div>
        <div>  
            @if ($errors->any())  
                <ul class="mb-10 red fs-1">  
                    @foreach ($errors->all() as $error)  
                        <li class="mb-1">{{ $error }}</li>  
                    @endforeach  
                </ul>  
            @endif  
        </div>
        <form action="/reply/{{$message->id}}" method="POST" class="contact-form">
            @csrf
            <p class="w-25vw bw fs-1">ご返信内容(1000文字以内)： <span id="content-preview"></span><span id="content-number"></span></p>
            <textarea name="content" id="content" class="fs-1" cols="50" rows="30" placeholder="ご返信内容はこちら" required></textarea>
            <input type="submit" id="form-post">
        </form>
        <div class="replies-block">
            <p class="mtb-10 fs-3">返信リスト</p>
            @foreach($replies as $reply)
                <div class="message-block">
                    @if($message->user_id !== $reply->user_id)
                        <div class="admin-comment mb-10 fs-1 w-80vw">
                            <p class="bw mb-5">{{$reply->content}}</p>
                            <p>返信者:{{$reply->user->name}}, 返信日：{{$reply->created_at}}</p>
                        </div>
                    @else
                        <div class="user-comment mb-10 fs-1 w-80vw">
                            <p class="bw mb-5">{{$reply->content}}</p>
                            <p>返信者:{{$reply->user->name}}, 返信日：{{$reply->created_at}}</p>
                        </div>
                    @endif
                </div>
            @endforeach
            {{ $replies->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>

    $(function(){
        //投稿確認
        $("#form-post").on("click", function(){
            if(window.confirm('入力内容に問題なければOKを押してください')) {
                return true;
            } else {
                return false;
            }
        });

        // メッセージの内容を表示する
        $('#content').keyup(function() {
            $('#content-preview').text($(this).val());
            $('#content-number').text(' (現在'+$(this).val().length+'文字)');
        });

    });

</script>