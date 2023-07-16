@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        @if(isset($recipes))
            @foreach($recipes as $recipe)
                <img src="{{$recipe['image']}}" alt="">
                <a href="https://spoonacular.com/recipes/{{str_replace(',','',str_replace('&','',str_replace(' ', '-', strtolower($recipe['title']))))}}-{{$recipe['id']}}">{{$recipe['title']}}</a>
                <a href="/favorite/{{$recipe['id']}}" class="like-link">お気に入り解除</a>
            @endforeach
            {{ $recipes->links('pagination::bootstrap-4') }}
        @else
            <p>上のフォームよりレシピの検索をしてみましょう。</p>
            <p>検索してもレシピが表示されない場合は検索条件を変更して再度検索をしてください。</p>
        @endif
    </div>
@endsection