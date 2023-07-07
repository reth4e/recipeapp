@extends('recipe.layout.layout')

@section('main')
    @if(isset($data))
        @foreach($data['results'] as $recipe)
            <p>{{$recipe['id']}}</p>
            <p>{{$recipe['title']}}</p>
            <img src="{{$recipe['image']}}" alt="">
        @endforeach
    @endif
@endsection