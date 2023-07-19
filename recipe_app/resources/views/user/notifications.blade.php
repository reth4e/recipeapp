@extends('recipe.layout.layout')

@section('main')
    <div class="container">
        <div class="notifications">
            @forelse ($notifications as $notification)
                <div class="notification mg-b-10">
                    <a href="/message/{{$notification -> data['id']}}">{{$notification->data['content']}}</a>
                    <p>{{$notification->created_at}}</p>
                </div>
            @empty
                <p>お知らせはありません</p>
            @endforelse
            {{ $notifications->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection