@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        <p>メッセージリスト</p>
        @foreach($messages as $message)
            <div class="message-block">
                <a href="/message/{{$message->id}}">{{$message->title}}</a>
                <p>投稿日：{{$message->created_at}}</p>
            </div>
        @endforeach
        {{ $messages->links('pagination::bootstrap-4') }}
    </div>
@endsection