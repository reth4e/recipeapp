<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Favorite;


class RecipeController extends Controller
{
    public function recipes(Request $request) { //レシピ取得

        //エンドポイント
        $endpoint = "https://api.spoonacular.com/recipes/complexSearch";

        // ページネーションするためにページ番号と1ページあたりのアイテム数を指定
        $page = request()->query('page', 1);
        $perPage = 10;

        $responses = [];

        $response = Http::get($endpoint, [
            'apiKey' => env('SPOONACULAR_KEY'),
            'query' => $request->word,
            'maxReadyTime' => (int)$request->maxReadyTime,
            'sort' => $request->sort,
            'number' => 100,
            'offset' => ($page - 1) * $perPage,
        ]);

        $responses[] = $response;
        
        if ($request->has('maxCalories')) {
            $response = Http::get($endpoint, [ //ここを変更、変数名をmax_caloriesに
                'apiKey' => env('SPOONACULAR_KEY'),
                'query' => $request->word,
                'maxCalories' => (int)$request->maxCalories,
                'sort' => $request->sort,
                'number' => 100,
                'offset' => ($page - 1) * $perPage,
            ]);
            $responses[] = $response; //ここを変更する
        }
        
        if ($request->has('minProtein')) {
            $response = Http::get($endpoint, [
                'apiKey' => env('SPOONACULAR_KEY'),
                'query' => $request->word,
                'minProtein' => (int)$request->minProtein,
                'sort' => $request->sort,
                'number' => 100,
                'offset' => ($page - 1) * $perPage,
            ]);
            $responses[] = $response;
        }
        
        $products = [];
        foreach ($responses as $response) {
            $products[] = $response->json()['results'];
        }

        $results = collect($products[0]); //取得した情報をコレクションにする
        for ($i = 1; $i < count($products); $i++) {
            $results = $results->intersect($products[$i]);
        }
        
        $recipes = new LengthAwarePaginator(
            $results,
            $results -> count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('recipe.recipes',compact('recipes'));
    }

    public function favorite($recipe_id) { //お気に入り追加or解除
        $login_user = Auth::user();
        $favorite = Favorite::where('user_id',$login_user->id)->where('recipe_id',$recipe_id)->first();

        if($favorite) {
            $favorite = $favorite->delete();
        } else {
            $favorite = new Favorite();
            $favorite->user_id = $login_user->id;
            $favorite->recipe_id = $recipe_id;
            $favorite->save();
        }
        return back();
    }

    public function favorites() { //お気に入り表示
        $login_user = Auth::user();
        $favorites = $login_user->favorites;
        // ページネーションするためにページ番号と1ページあたりのアイテム数を指定
        $page = request()->query('page', 1);
        $perPage = 10;

        $recipes = [];

        foreach($favorites as $favorite) {
            $endpoint = "https://api.spoonacular.com/recipes/".$favorite->recipe_id."/information";
            $response = Http::get($endpoint, [
                'apiKey' => env('SPOONACULAR_KEY'),
            ]);

            if ($response->ok()) {
                $recipeData = $response->json(); // レスポンスからJSONデータを取得
                $recipes[] = $recipeData; // レシピデータを配列に追加
            }

        }
        $recipes = collect($recipes);
        $total = $recipes->count();
        $offset = ($page - 1) * $perPage;
        $recipes = $recipes->slice($offset, $perPage)->all();

        $recipes = new LengthAwarePaginator(
            $recipes,
            $total,
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
        return view('recipe.favorites',compact('recipes'));
    }

    public function guide() {
        return view('guide');
        
    }
}
