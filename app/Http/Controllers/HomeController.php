<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\SavedRecipe;
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
    public function homepage() // displays all recipes from recipes table
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

    public function saveRecipeFromHome(Request $request, $recipe_id)
    {
        $user = Auth::user();

        // Check if the recipe already exists in the saved recipes
        $savedRecipe = SavedRecipe::where('user_id', $user->id)
            ->where('recipe_id', $recipe_id)
            ->first();

        if (!$savedRecipe) {
            SavedRecipe::create([
                'user_id' => $user->id,
                'recipe_id' => $recipe_id,
            ]);
            return redirect()->back()->with('success', 'Recipe has been added to your saved recipes.');
        }
        return redirect()->back()->with('status', 'Recipe is already in your saved recipes.');
    }
}
