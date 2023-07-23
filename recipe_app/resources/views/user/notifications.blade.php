@extends('recipe.layout.layout')

@section('main')
    <div class="container">
        <div class="notifications w-80vw m-lr-auto">
            <p class="ttl">通知</p>
            @forelse ($notifications as $notification)
                <div class="notification mb-10 bc-eee p-5">
                    <a href="/message/{{$notification -> data['id']}}" class="fs-1 bw d-ib mb-1">{{$notification->data['content']}}</a>
                    <p class="fs-1">投稿日：{{$notification->created_at}}</p>
                    @if(auth()->user()->is_admin != 1)
                    <a href="/notification/{{$notification -> id}}" class="fs-1">既読にする</a>
                    @endif
                </div>
            @empty
                <p class="fs-1">お知らせはありません</p>
            @endforelse
            {{ $notifications->links('pagination::bootstrap-4') }}
        </div>
    </div>
@endsection