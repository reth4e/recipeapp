@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        <p class="ttl">メッセージリスト</p>
        @foreach($messages as $message)
            <div class="message-block mb-10">
                <a href="/message/{{$message->id}}" class="fs-1 bw mb-1">{{$message->title}}</a>
                <p class="fs-1">ユーザー名:{{$message->user->name}}, 投稿日：{{$message->created_at}}</p>
            </div>
        @endforeach
        {{ $messages->links('pagination::bootstrap-4') }}
    </div>
@endsection