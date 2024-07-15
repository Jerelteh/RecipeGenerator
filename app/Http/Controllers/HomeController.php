<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    //////////////////////////////////////////////////////////////////
    public function homepage()
    {
        $recipes = Recipe::all();
        return view('homepage', ['recipes' => $recipes]);
    }
    public function viewRecipe($recipeID)
    {
        $recipe = Recipe::findOrFail($recipeID);
        return view('viewRecipeFromHome', [
            'recipeTitle' => $recipe->title,
            'recipeBody' => $recipe->content,
            'recipeID' => $recipe->id
        ]);
    }
}
