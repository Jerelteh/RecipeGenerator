<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function saveRecipe(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $recipe = new Recipe();
        $recipe->title = $data['title'];
        $recipe->content = $data['content'];
        $recipe->user_id = Auth::id(); // associate with logged-in user
        $recipe->save();

        return redirect()->route('view.recipe', ['id' => $recipe->id])->with('status', 'Recipe saved successfully!');
    }
    public function deleteRecipe(int $recipeID)
    {
        $recipe = Recipe::findOrFail($recipeID);
        $recipe->delete();

        return redirect()->route('recipe.list')->with('status', 'Recipe deleted successfully!');
    }
    public function viewRecipe($recipeID)
    {
        $recipe = Recipe::findOrFail($recipeID);
        return view('viewRecipe', [
            'recipeBody' => $recipe->content,
            'recipeTitle' => $recipe->title,
            'recipeID' => $recipe->id
        ]);
    }
    public function listRecipes()
    {
        $recipes = Recipe::where('user_id', Auth::id())->get(); // Fetch recipes for the logged-in user
        return view('recipeList', ['recipes' => $recipes]);
    }
    public function editRecipe($recipeID) // for finding existing recipe to edit
    {
        $recipe = Recipe::findOrFail($recipeID);
        return view('editRecipe', ['recipe' => $recipe]);
    }
    public function updateRecipe(Request $request, $recipeID) // for updating existing recipe
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $recipe = Recipe::findOrFail($recipeID);
        $recipe->title = $data['title'];
        $recipe->content = $data['content'];
        $recipe->save();

        return redirect()->route('view.recipe', ['id' => $recipe->id])->with('status', 'Recipe updated successfully!');
    }
    public function editTempRecipe(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');
        return view('editTempRecipe', ['title' => $title, 'content' => $content]);
    }
}
