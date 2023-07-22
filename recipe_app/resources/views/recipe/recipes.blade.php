@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        @if($recipes)
            <div class="flex wrap gap-5 ml-8">
                @foreach($recipes as $recipe)
                    <div class="recipe-card mb-10">
                        <img src="{{$recipe['image']}}" alt="" class="image mb-1">
                        <a class="ds-b mb-1 fs-1" href="https://spoonacular.com/recipes/{{str_replace(',','',str_replace('&','',str_replace(' ', '-', strtolower($recipe['title']))))}}-{{$recipe['id']}}">{{$recipe['title']}}</a>
                        <a href="/favorite/{{$recipe['id']}}" class="ds-b like-link mb-1 fs-1">
                            @if (auth() -> user()-> favorites() -> where('user_id', Auth::id()) -> where('recipe_id', $recipe['id']) -> exists())
                                お気に入り解除
                            @else
                                お気に入り登録
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>
            {{ $recipes->links('pagination::bootstrap-4') }}
        @else
            <p class="fs-1">上のフォームよりレシピの検索をしてみましょう。</p>
            <p class="fs-1">検索してもレシピが表示されない場合は検索条件を緩和して再度検索をしてください。</p>
        @endif
    </div>
@endsection