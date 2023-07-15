@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        @foreach($messages as $message)
            <div class="message-block">
                <a href="/message/{{$message->id}}">{{$message->title}}</a>
            </div>
        @endforeach
    </div>
@endsection