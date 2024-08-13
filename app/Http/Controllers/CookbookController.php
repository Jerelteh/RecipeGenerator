<?php

namespace App\Http\Controllers;

use App\Models\Cookbook;
use App\Models\Recipe;
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
        // $recipes = Recipe::where('user_id', Auth::id())->get(); // Fetch recipes from user account
        $recipes = Auth::user()->recipes; // Get the user's saved recipes to add to cookbook
        return view('addRecipeToCookbook', compact('cookbook', 'recipes'));
    }

    public function addRecipe(Request $request, Cookbook $cookbook)
    {
        $request->validate([
            'recipe_ids' => 'required|array',
            'recipe_ids.*' => 'exists:recipes,id',
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
}
