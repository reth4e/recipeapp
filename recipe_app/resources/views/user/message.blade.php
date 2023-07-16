@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        <div class="message-block">
            <p>{{$message->title}}</p>
            <p>投稿日：{{$message->created_at}}</p>
            <p>{{$message->content}}</p>
            <!-- <p>ここに返信の内容をforeachで</p> -->
            <form action="/reply/{{$message->id}}" method="POST"></form>
        </div>
    </div>
@endsection