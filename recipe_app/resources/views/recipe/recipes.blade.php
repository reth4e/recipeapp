@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        @if($recipes)
            @foreach($recipes as $recipe)
                <div class="recipe-card">
                    <img src="{{$recipe['image']}}" alt="">
                    <a href="https://spoonacular.com/recipes/{{str_replace(',','',str_replace('&','',str_replace(' ', '-', strtolower($recipe['title']))))}}-{{$recipe['id']}}">{{$recipe['title']}}</a>
                    <a href="/favorite/{{$recipe['id']}}" class="like-link">
                        @if (auth() -> user()-> favorites() -> where('user_id', Auth::id()) -> where('recipe_id', $recipe['id']) -> exists())
                            お気に入り解除
                        @else
                            お気に入り登録
                        @endif
                    </a>
                </div>
            @endforeach
            {{ $recipes->links('pagination::bootstrap-4') }}
        @else
            <p>上のフォームよりレシピの検索をしてみましょう。</p>
            <p>検索してもレシピが表示されない場合は検索条件を緩和して再度検索をしてください。</p>
        @endif
    </div>
@endsection