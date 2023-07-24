<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Models\User;
use App\Models\Favorite;

class RecipeControllerTest extends TestCase
{ //RecipeControllerに関するテスト
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRecipes ()
    {
        // recipesのテスト
        $login_user = User::factory() -> create();
        
        $response = $this -> actingAs($login_user);
        Http::fake([
            'https://api.spoonacular.com/recipes/complexSearch*' => Http::response([
                'results' => [
                    ['id' => 1, 'title' => 'Recipe 1','image' => 'sample.jpg']
                ]
            ], 200),
        ]);

        // テスト条件を設定
        $data = [
            'word' => 'pasta',
            'maxReadyTime' => 30,
            'sort' => 'price',
            // 他のテスト条件をここに追加
        ];

        // テスト対象のアクションを呼び出す
        $response = $this->get('/recipes', $data);

        // 検証: レシピが正しく表示されることを確認
        $response->assertSee('Recipe 1');
    }
    

    

    
}
