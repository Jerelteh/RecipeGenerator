<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Support\Facades\Auth;
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
        $cookbooks = Auth::user()->cookbooks; // Get cookbooks for the logged-in user
        return view('homepage', compact('recipes', 'cookbooks'));
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
    public function viewRecipeFromHome($id)
    {
        $recipe = Recipe::findOrFail($id);
        return view('viewRecipeFromHome', compact('recipe'));
    }
}
