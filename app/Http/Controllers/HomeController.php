<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\SavedRecipe;
use App\Models\Tag;
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

        // Fetch the latest 5 recipes with images
        $recentRecipes = Recipe::whereNotNull('image')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Fetch all tags for the category cards
        $categories = Tag::all();

        return view('homepage', [
            'recentRecipes' => $recentRecipes,
            'categories' => $categories,
            'recipes' => $recipes,
            'cookbooks' => $cookbooks,
        ]);
    }
    // public function viewRecipe($recipeID)
    // {
    //     $recipe = Recipe::findOrFail($recipeID);
    //     return view('viewRecipeFromHome', [
    //         'recipeTitle' => $recipe->title,
    //         'recipeBody' => $recipe->content,
    //         'recipeID' => $recipe->id
    //     ]);
    // }
    public function viewRecipeFromHome($id)
    {
        $recipe = Recipe::findOrFail($id);
        $tags = $recipe->tags;
        return view('viewRecipeFromHome', [
            'recipeBody' => $recipe->content,
            'recipeTitle' => $recipe->title,
            'calories' => $recipe->calories,
            'image' => $recipe->image,
            'recipeID' => $recipe->id,
            'tags' => $tags,
            'allTags' => Tag::all()->pluck('name', 'id'),
        ]);
    }

    public function saveRecipeFromHome(Request $request, $recipe_id)
    {
        $user = Auth::user();

        // Check if the recipe belongs to the user in recipes table
        $recipe = Recipe::where('id', $recipe_id)
            ->where('user_id', $user->id)
            ->first();
        if ($recipe) {
            // Recipe already belongs to the user
            return redirect()->back()->with('alert', 'This recipe was created by you, it is already saved in your recipe libraries.');
        }

        // Check if the recipe exists in the saved recipes
        $savedRecipe = SavedRecipe::where('user_id', $user->id)
            ->where('recipe_id', $recipe_id)
            ->first();
        if ($savedRecipe) {
            // Recipe already exists in saved_recipes
            return redirect()->back()->with('status', 'Recipe is already in your saved recipes.');
        }

        // Save recipe to saved_recipes
        SavedRecipe::create([
            'user_id' => $user->id,
            'recipe_id' => $recipe_id,
        ]);
        return redirect()->back()->with('success', 'Recipe has been added to your saved recipes.');
    }
}
