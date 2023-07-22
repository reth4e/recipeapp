@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        <p class="ttl">お気に入りリスト</p>
        @if($recipes)
            <div class="flex wrap gap-5 ml-8">
                @foreach($recipes as $recipe)
                    <div class="recipe-card mb-10">
                        <img src="{{$recipe['image']}}" alt="" class="image mb-1">
                        <a class="ds-b mb-1 fs-1" href="https://spoonacular.com/recipes/{{str_replace(',','',str_replace('&','',str_replace(' ', '-', strtolower($recipe['title']))))}}-{{$recipe['id']}}">{{$recipe['title']}}</a>
                        <a href="/favorite/{{$recipe['id']}}" class="ds-b like-link mb-1 fs-1">お気に入り解除</a>
                    </div>
                @endforeach
            </div>
            {{ $recipes->links('pagination::bootstrap-4') }}
        @else
            <p class="fs-1">レシピの検索後、お気に入り登録をしてみましょう。</p>
        @endif
    </div>
@endsection