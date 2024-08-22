<?php

namespace App\Http\Controllers;

use App\Models\Cookbook;
use App\Models\Recipe;
use App\Models\SavedRecipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CookbookController extends Controller
{
    public function listCookbooks()
    {
        $cookbooks = Auth::user()->cookbooks;
        return view('cookbookList', compact('cookbooks'));
    }

    public function createCookbook()
    {
        return view('createCookbook');
    }

    public function saveCookbook(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);
        $cookbook = Cookbook::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
        ]);
        return redirect()->route('cookbooks')->with('success', 'Cookbook created successfully.');
    }

    public function viewCookbook(Cookbook $cookbook)
    {
        if ($cookbook->user_id !== Auth::id()) {
            abort(403);
        }
        $recipes = $cookbook->recipes; // retrieve the recipes associated with the cookbook
        $totalCalories = $recipes->sum('calories');
        return view('viewCookbook', compact('cookbook', 'recipes', 'totalCalories'));
    }

    public function addRecipeForm(Cookbook $cookbook)
    {
        // $userRecipes = Auth::user()->recipes;
        // $savedRecipes = Auth::user()->savedRecipes;

        // $user = Auth::user();
        // $userRecipes = $user->recipes;
        // $savedRecipes = SavedRecipe::where('user_id', $user->id)->with('recipe')->get();

        // $userRecipes = Auth::user()->recipes;
        // $savedRecipes = Auth::user()->savedRecipes()->with('recipe')->get();

        $userRecipes = Auth::user()->recipes;
        $savedRecipes = SavedRecipe::where('saved_recipes.user_id', Auth::id())
            ->join('recipes', 'saved_recipes.recipe_id', '=', 'recipes.id')
            ->select('recipes.id', 'recipes.title')
            ->get();

        return view('addRecipeToCookbook', compact('cookbook', 'userRecipes', 'savedRecipes'));
    }

    public function addRecipe(Request $request, Cookbook $cookbook)
    {
        $request->validate([
            'recipe_ids' => 'required|array',
            'recipe_ids.*' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Recipe::where('id', $value)->exists() && !SavedRecipe::where('id', $value)->exists()) {
                        $fail('The selected recipe does not exist.');
                    }
                },
            ],
        ]);

        // Filter out recipes that are already attached to the cookbook
        $existingRecipeIds = $cookbook->recipes()->pluck('recipe_id')->toArray();
        $duplicateRecipes = array_intersect($existingRecipeIds, $request->recipe_ids);
        if (!empty($duplicateRecipes)) {
            // Redirect back to the viewCookbook page with an error message
            return redirect()->route('cookbooks.view', $cookbook->id)
                ->with('error', 'Alert!!!  Selected recipe already exist in this cookbook.');
        }

        // Attach the non-duplicate recipes to the cookbook
        $cookbook->recipes()->attach($request->recipe_ids);
        return redirect()->route('cookbooks.view', $cookbook->id)->with('success', 'Recipe added to cookbook successfully.');
    }

    public function removeRecipe(Cookbook $cookbook, Recipe $recipe)
    {
        // Detach the recipe from the cookbook
        $cookbook->recipes()->detach($recipe->id);

        // Redirect back to the viewCookbook page with a success message
        return redirect()->route('cookbooks.view', $cookbook->id)->with('success', 'Recipe has been removed from the cookbook.');
    }

    public function addRecipeFromHomepage(Request $request) // adds recipe to cookbook from homepage
    {
        $request->validate([
            'cookbook_id' => 'required|exists:cookbooks,id',
            'recipe_id' => 'required|exists:recipes,id',
        ]);

        $cookbook = Cookbook::findOrFail($request->cookbook_id);

        // Check if the recipe is already in the cookbook
        if ($cookbook->recipes()->where('recipe_id', $request->recipe_id)->exists()) {
            return redirect()->back()->with('error', 'Recipe already exists in the selected cookbook.');
        }

        // Add the recipe to the cookbook
        $cookbook->recipes()->attach($request->recipe_id);

        return redirect()->back()->with('success', 'Recipe added to the cookbook successfully!');
    }
}
