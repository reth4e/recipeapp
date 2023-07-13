<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class RecipeController extends Controller
{
    public function recipes() { //レシピ取得
        //エンドポイント
        $endpoint = "https://api.spoonacular.com/recipes/complexSearch";

        // ページネーションするためにページ番号と1ページあたりのアイテム数を指定
        $page = request()->query('page', 1);
        $perPage = 10;

        $response = Http::get($endpoint, [
            'apiKey' => env('SPOONACULAR_KEY'),
            'query' => 'apple',
            'number' => $perPage,
            'offset' => ($page - 1) * $perPage,
        ]);
        //取得した情報をコレクションにする
        $results = collect($response->json()['results']);

        $recipes = new LengthAwarePaginator(
            $results,
            $response->json()['totalResults'],
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('recipe.recipes',compact('recipes'));
    }
}
