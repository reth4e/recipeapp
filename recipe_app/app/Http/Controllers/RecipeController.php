<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\Favorite;

class RecipeController extends Controller
{
    private function arrayMultiIntersect($array1, $array2, $compareFunction) //2つの多次元配列の積集合を取得
    {
        return array_filter($array1, function ($item) use ($array2, $compareFunction) {
            foreach ($array2 as $array2Item) {
                if ($compareFunction($item, $array2Item)) {
                    return true;
                }
            }
            return false;
        });
    }

    public function recipes(Request $request) { //検索条件でレシピ取得

        $compareDeepValue = function ($val1, $val2)  //id属性の値を比較
        {
            return $val1['id']===$val2['id'];
        };

        //エンドポイント
        $endpoint = "https://api.spoonacular.com/recipes/complexSearch";

        // ページネーションするためにページ番号と1ページあたりのアイテム数を指定
        $page = request()->query('page', 1);
        $perPage = 10;

        $responses = [];

        if ($request->sort === 'price' || $request->sort === 'time') { //ソート基準が時間かお金の場合はsortDirectionを昇順にする
            $response = Http::get($endpoint, [ //準備時間の最大値を設定して取得
                'apiKey' => env('SPOONACULAR_KEY'),
                'query' => $request->word,
                'maxReadyTime' => (int)$request->maxReadyTime,
                'sort' => $request->sort,
                'sortDirection' => 'asc',
                'number' => 100,
                'offset' => ($page - 1) * $perPage,
            ]);
            $responses[] = $response->json()['results'];
            
            if ($request->has('maxCalories')) { //最大カロリー量を設定して取得
                $response = Http::get($endpoint, [ 
                    'apiKey' => env('SPOONACULAR_KEY'),
                    'query' => $request->word,
                    'maxCalories' => (int)$request->maxCalories,
                    'sort' => $request->sort,
                    'sortDirection' => 'asc',
                    'number' => 100,
                    'offset' => ($page - 1) * $perPage,
                ]);
                $responses[] = $response->json()['results']; 
            }
            
            if ($request->has('minProtein')) { //最小タンパク質量を設定して取得
                $response = Http::get($endpoint, [
                    'apiKey' => env('SPOONACULAR_KEY'),
                    'query' => $request->word,
                    'minProtein' => (int)$request->minProtein,
                    'sort' => $request->sort,
                    'sortDirection' => 'asc',
                    'number' => 100,
                    'offset' => ($page - 1) * $perPage,
                ]);
                $responses[] = $response->json()['results'];
            }
        } else { //ソート基準が時間かお金以外の場合はsortDirectionを降順(デフォルト)にする
            $response = Http::get($endpoint, [ //準備時間の最大値を設定して取得
                'apiKey' => env('SPOONACULAR_KEY'),
                'query' => $request->word,
                'maxReadyTime' => (int)$request->maxReadyTime,
                'sort' => $request->sort,
                'number' => 100,
                'offset' => ($page - 1) * $perPage,
            ]);
            $responses[] = $response->json()['results'];
            
            if ($request->has('maxCalories')) { //最大カロリー量を設定して取得
                $response = Http::get($endpoint, [ 
                    'apiKey' => env('SPOONACULAR_KEY'),
                    'query' => $request->word,
                    'maxCalories' => (int)$request->maxCalories,
                    'sort' => $request->sort,
                    'number' => 100,
                    'offset' => ($page - 1) * $perPage,
                ]);
                $responses[] = $response->json()['results']; 
            }
            
            if ($request->has('minProtein')) { //最小タンパク質量を設定して取得
                $response = Http::get($endpoint, [
                    'apiKey' => env('SPOONACULAR_KEY'),
                    'query' => $request->word,
                    'minProtein' => (int)$request->minProtein,
                    'sort' => $request->sort,
                    'number' => 100,
                    'offset' => ($page - 1) * $perPage,
                ]);
                $responses[] = $response->json()['results'];
            }
        }
        
        

        $results = $responses[0]; 
        for ($i = 1; $i < count($responses); $i++) { //and検索のために積集合を取得
            $results = $this->arrayMultiIntersect($results, $responses[$i], $compareDeepValue);
        }

        $results = collect($results);
        $total = $results->count();
        $offset = ($page - 1) * $perPage;
        $results = $results->slice($offset, $perPage)->all();

        $recipes = new LengthAwarePaginator(
            $results,
            $total,
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
            session()->flash('status', 'お気に入り解除しました');
        } else {
            $favorite = new Favorite();
            $favorite->user_id = $login_user->id;
            $favorite->recipe_id = $recipe_id;
            $favorite->save();
            session()->flash('status', 'お気に入り登録しました');
        }


        return back();
    }

    public function favorites() { //お気に入りリスト表示
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

    public function guide() { //使い方ページ表示
        return view('guide');
    }
}
