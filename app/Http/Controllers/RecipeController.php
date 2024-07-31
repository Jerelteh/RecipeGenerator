<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\RecipeInput;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    public function saveRecipe(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'calories' => 'required|integer',
        ]);

        $recipe = new Recipe();
        $recipe->title = $data['title'];
        $recipe->content = $data['content'];
        $recipe->calories = $data['calories'];
        $recipe->user_id = Auth::id(); // associate with logged-in user
        $recipe->save();

        RecipeInput::create([
            'recipe_id' => $recipe->id,
            'question1' => session('question1'),
            'question2' => session('question2'),
            'question3' => session('question3'),
            'question4' => session('question4'),
            'question5' => session('question5'),
        ]);
        // clear session values after saving recipe
        $this->clearRecipeSession();

        return redirect()->route('view.recipe', ['id' => $recipe->id])->with('status', 'Recipe saved successfully!');
    }
    public function overwriteRecipe(Request $request, $recipeID)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'calories' => 'required|integer',
        ]);

        $recipe = Recipe::findOrFail($recipeID);
        $recipe->title = $data['title'];
        $recipe->content = $data['content'];
        $recipe->calories = $data['calories'];
        $recipe->save();

        $recipeInput = RecipeInput::where('recipe_id', $recipe->id)->first();
        $recipeInput->update([
            'question1' => session('question1'),
            'question2' => session('question2'),
            'question3' => session('question3'),
            'question4' => session('question4'),
            'question5' => session('question5'),
        ]);

        $this->clearRecipeSession();
        return redirect()->route('recipe.list')->with('status', 'Recipe overwritten successfully!');
    }
    private function clearRecipeSession() // clears session values
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
            'calories' => $recipe->calories,
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
            'calories' => 'required|integer',
        ]);

        $recipe = Recipe::findOrFail($recipeID);
        $recipe->title = $data['title'];
        $recipe->content = $data['content'];
        $recipe->calories = $data['calories'];
        $recipe->save();

        return redirect()->route('view.recipe', ['id' => $recipe->id])->with('status', 'Recipe updated successfully!');
    }
    public function editTempRecipe(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');
        $calories = $request->input('calories');
        return view('editTempRecipe', [
            'title' => $title,
            'content' => $content,
            'calories' => $calories,
            'recipeID' => $request->input('recipeID'),
            'isEditing' => $request->input('isEditing')
        ]);
    }
    public function updateTempRecipe(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'calories' => 'required|integer',
        ]);

        return view('generatedRecipe', [
            'recipeBody' => $data['content'],
            'recipeTitle' => $data['title'],
            'calories' => $data['calories'],
            'recipeID' => $request->input('recipeID'),
            'isEditing' => $request->input('isEditing', true) // Ensure isEditing is set when coming from editTempRecipe
        ]);
    }
}
