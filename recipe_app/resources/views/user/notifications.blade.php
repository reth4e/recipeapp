@extends('recipe.layout.layout')

@section('main')
    <div class="container">
        <div class="notifications">
            @forelse ($notifications as $notification)
                <div class="notification mg-b-10">
                    <a href="/message/{{$notification -> data['id']}}">{{$notification->data['content']}}</a>
                    <p>投稿日：{{$notification->created_at}}</p>
                    @if(auth()->user()->is_admin != 1)
                    <a href="/notification/{{$notification -> id}}">既読にする</a>
                    @endif
                </div>
            @empty
                <p>お知らせはありません</p>
            @endforelse
            {{ $notifications->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection