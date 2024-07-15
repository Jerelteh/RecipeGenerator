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

        // clear session values after saving recipe
        $this->clearSessionValues();

        return redirect()->route('view.recipe', ['id' => $recipe->id])->with('status', 'Recipe saved successfully!');
    }
    private function clearSessionValues() // clears session values
    {
        session()->forget(['question1', 'question2', 'question3', 'question4', 'question5']);
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
    public function editRecipe($recipeID) // directing to editRecipe page
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
        return view('editTempRecipe', ['title' => $title, 'content' => $content, 'recipeID' => null]);
    }
    public function updateTempRecipe(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);
        // Redirect back to the generatedRecipe view with updated content
        return view('generatedRecipe', [
            'recipeBody' => $data['content'],
            'recipeTitle' => $data['title'],
            'recipeID' => null
        ]);
    }
}
