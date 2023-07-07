<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class RecipeController extends Controller
{
    public function recipes() {
        
        // APIキー
        $api_key = env('SPOONACULAR_KEY');

        //エンドポイント
        $url = "https://api.spoonacular.com/recipes/complexSearch?apiKey=".$api_key."&query=apple&maxReadyTime=20&number=5";

        $response = Http::get($url);
        $data = $response ->getBody();
        $data = json_decode($data, true);

        return view('recipe.recipes',compact('data'));
    }
}
