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
            
            <form action="/recipes" method="get" class="header-form">
                <input class="search" type="text" name="word" placeholder="レシピ検索" required/>
                <label>最大料理時間(分)
                    <select name="maxReadyTime">
                        <option value="20">20</option>
                        <option value="30" selected>30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="60">60</option>
                    </select>
                </label>
                <label>最大カロリー(kcal)
                    <select name="maxCalories">
                        <option value=""></option>
                        <option value="300">300</option>
                        <option value="400">400</option>
                        <option value="500">500</option>
                        <option value="600">600</option>
                    </select>
                </label>
                <label>最小タンパク質(g)
                    <select name="minProtein">
                        <option value=""></option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                    </select>
                </label>
                <label>ソート基準
                    <select name="sort">
                        <option value="">なし</option>
                        <option value="price">値段</option>
                        <option value="time">時間</option>
                        <option value="healthiness">健康度</option>
                        <option value="random">ランダム</option>
                    </select>
                </label>
                <input class="btn search-btn" type="submit" value="検索">
            </form>
            
            <nav class="header-nav">
                <ul>
                    <li class="header-link"><a href="/favorites">お気に入り</a></li>
                    <li class="header-link"><a href="/guide">使い方</a></li>
                    <li class="header-link"><a href="/contact">お問い合わせ</a></li>
                    <li class="header-link"><a href="/list_messages">メッセージ</a></li>
                    <li class="header-link"><a href="/notifications">通知</a></li>
                    <li class="header-link">
                        <form action="/logout" method="post" class="form-logout">
                            @csrf
                            <input class="btn btn-logout" type="submit" value="ログアウト">
                        </form>
                    </li>
                </ul>
            </nav>
        </header>
        
        <main>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @yield('main')
        </main>

        <footer>
            <small class="footer-logo">2023. mendorecipe</small>
        </footer>
    </body>

</html>