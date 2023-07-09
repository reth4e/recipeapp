


    @if(isset($recipes))
        @foreach($recipes as $recipe)
            <a href="https://spoonacular.com/recipes/{{str_replace(' ', '-', strtolower($recipe['title']))}}-{{$recipe['id']}}">{{$recipe['title']}}</a>
            <img src="{{$recipe['image']}}" alt="">
        @endforeach
        {{ $recipes->links('pagination::bootstrap-4') }}
    @endif
    <!-- @section('main') -->
<!-- @endsection -->