@extends('recipe.layout.layout')
@section('main')
    <div class="container">
        <p class="ttl">使い方ページ</p>
        <div class="w-80vw m-lr-auto">
            <p class="bw fs-1 mb-1">上部の検索フォームに検索条件を入れて検索をします。</p>
            <img src="../../storage/images/search.png" alt="検索" class="w-60vw mb-10">
            <p class="bw fs-1 mb-1">検索結果が表示されます。青字のタイトルはレシピページへのリンクになっています。お気に入り登録もこの画面で行えます。</p>
            <img src="../../storage/images/recipes.png" alt="検索結果" class="w-60vw mb-10">
            <p class="bw fs-1 mb-1">こちらがレシピページの例です。外部サイトであるSpoonacularのものとなっています。</p>
            <img src="../../storage/images/recipe.png" alt="個別ページ" class="w-60vw mb-10">
        </div>
    </div>
@endsection