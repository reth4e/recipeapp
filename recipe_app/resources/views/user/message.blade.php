@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        <div class="message-block">
            <p>{{$message->title}}</p>
            <p>投稿日：{{$message->created_at}}</p>
            <p>{{$message->content}}</p>
        </div>
        <div>  
            @if ($errors->any())  
                <ul>  
                    @foreach ($errors->all() as $error)  
                        <li>{{ $error }}</li>  
                    @endforeach  
                </ul>  
            @endif  
        </div>
        <form action="/reply/{{$message->id}}" method="POST">
            @csrf
            <p class="w-25vw bw">ご返信内容(1000文字以内)： <span id="content-preview"></span><span id="content-number"></span></p>
            <textarea name="content" id="content" cols="30" rows="10"  placeholder="ご返信内容はこちら" required></textarea>
            <input type="submit" id="form-post">
        </form>
        <div class="replies-block">
            <p>返信リスト</p>
            @foreach($replies as $reply)
                <div class="message-block">
                    <p>{{$reply->content}}</p>
                    @if($message->user_id !== $reply->user_id)
                        <p class="admin-comment">返信日：{{$reply->created_at}}</p>
                    @else
                        <p class="user-comment">返信日：{{$reply->created_at}}</p>
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