<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RecipeControllerTest extends TestCase
{ //RecipeControllerに関するテスト
    /**
     * A basic feature test example.
     *
     * @return void
     */

    use DatabaseTransactions;
    public function testRecipes ()
    {
        // recipesのテスト
        $login_user = User::factory() -> create();
        
        $this -> actingAs($login_user);
        Http::fake([
            'https://api.spoonacular.com/recipes/complexSearch*' => Http::response([
                'results' => [
                    ['id' => 1, 'title' => 'Recipe 1','image' => 'sample1.jpg']
                ]
            ], 200),
        ]);

        // テスト条件を設定
        $data = [
            'word' => 'pasta',
            'maxReadyTime' => 30,
            'sort' => 'price',
            
        ];

        // テスト対象のアクションを呼び出す
        $response = $this->get('/recipes', $data);

        // 検証: レシピが正しく表示されることを確認
        $response->assertStatus(200);
        $response->assertSee('Recipe 1');
    }
    

    public function testFavorite() { //favoriteのテスト
        $login_user = User::factory() -> create();
        $this -> actingAs($login_user);

        $recipe_id = 1;
        $response = $this->get(route('favorite', [ //お気に入り登録
            'recipe_id' => $recipe_id,
        ]));

        $this -> assertDatabaseHas('favorites', [ //お気に入り登録されているか確認
            'recipe_id' => $recipe_id,
            'user_id' => $login_user->id,
        ]);

        $response = $this->get(route('favorite', [ //お気に入り解除
            'recipe_id' => $recipe_id,
        ]));

        $this -> assertDatabaseMissing('favorites', [ //お気に入り解除されているか確認
            'recipe_id' => $recipe_id,
            'user_id' => $login_user->id,
        ]);
    }

    public function testFavorites() { //favoritesのテスト
        $login_user = User::factory() -> create();
        $this -> actingAs($login_user); 

        
        $recipe_id = 1;
        $response = $this->get(route('favorite', [ //お気に入り登録
            'recipe_id' => $recipe_id,
        ]));

        $response = $this->get('/favorites');
        $response->assertStatus(200);
        $response->assertSee('Fried Anchovies with Sage'); //id1のレシピのタイトル

    }
}
