@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        <p class="ttl">メッセージリスト</p>
        @foreach($messages as $message)
            <div class="message-block mb-10 bc-eee w-80vw m-lr-auto p-5">
                <a href="/message/{{$message->id}}" class="fs-1 bw mb-1 d-ib">{{$message->title}}</a>
                <p class="fs-1">ユーザー名:{{$message->user->name}}, 投稿日：{{$message->created_at}}</p>
            </div>
        @endforeach
        {{ $messages->links('pagination::bootstrap-4') }}
    </div>
@endsection