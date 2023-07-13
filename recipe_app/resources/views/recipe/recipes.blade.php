


    @if(isset($recipes))
        @foreach($recipes as $recipe)
            <a href="https://spoonacular.com/recipes/{{str_replace(' ', '-', strtolower($recipe['title']))}}-{{$recipe['id']}}">{{$recipe['title']}}</a>
            <img src="{{$recipe['image']}}" alt="">
        @endforeach
        {{ $recipes->links('pagination::bootstrap-4') }}
    @else
        <p>上のフォームよりレシピの検索をしてみましょう。</p>
        <p>検索してもレシピが表示されない場合は検索条件を変更して再度検索をしてください。</p>
    @endif
    <!-- @section('main') -->
<!-- @endsection -->