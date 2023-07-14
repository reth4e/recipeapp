<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>mendorecipe</title>
        <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    </head>

    <body>
        <header class = "header">
            <p class="header-logo">mendorecipe</p>
            
            <!-- <form action="/pictures?contents={{$search_tags}}" method="get" class="header-form">
                <input class="search" type="text" name="contents" placeholder="タグ名検索" value ="{{$search_tags}}" />
                <label>新しい順
                    <input type="radio" name="dateorder" value="new">
                </label>
                <label>古い順
                    <input type="radio" name="dateorder" value="old">
                </label>
                <input class="btn search-btn" type="submit" value="検索">
            </form> -->
            
            <!-- <nav class="header-nav">
                <p class="header-menu" id="menu">メニュー</p> -->
                <!-- 以下はクリックで表示 -->
                <!-- <div class="dropdown" id = "dropdown">
                    <div class="notification-block">
                        <button class="btn-notification btn" id="btn-notification">通知</button>

                        @if ($notifications -> count() > 0)
                            <span>{{$notifications -> count()}}</span>
                        @endif

                        <div class="header-notifications" id="notifications">

                            @if ($notifications -> count() > 0)
                                <a href="/user/notifications" class="block">通知ページへ</a>
                                <a href="/user/readall" class="mg-b-3 red block">すべて既読にする</a>
                            @endif

                            @forelse ($notifications as $notification)
                                <div class="header-notification mg-b-3">
                                    <a href="/user/message/{{$notification -> data['id']}}">{{$notification->data['message']}}</a>
                                    <p>{{$notification->created_at}}</p>
                                    <a href="/user/read/{{$notification -> id}}">既読にする</a>
                                </div>
                            @empty
                                <p>お知らせはありません</p>
                            @endforelse

                        </div>
                        
                    </div>
                    <ul>
                        <li class="header-link"><a href="/user/message">メッセージ</a></li>
                        <li class="header-link"><a href="/favorites">お気に入り</a></li>
                    </ul>
                </div>
            </nav> -->
        </header>
        
        <main>
            @yield('main')
        </main>
    </body>

</html>