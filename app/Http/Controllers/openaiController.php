<?php

namespace App\Http\Controllers;

use App\AI\Chat;
use App\Models\Recipe;
use Illuminate\Http\Request;

class openaiController extends Controller
{
    public function submitInput(Request $request)
    {
        $data = $request->validate([
            'question1' => 'string',
            'question2' => 'string',
            'question3' => 'string',
        ]);

        $input = new Chat();
        $message = "Dish: {$data['question1']}\nIngredients: {$data['question2']}\nPreferred Time(mins): {$data['question3']}";
        $response = $input
            ->systemMessage('You are a text to recipe generator. You will generate the following things accordingly: 
                            detailed but short steps, ingredients used, estimated completion time, estimated calorie. 
                            Recipe should cater to beginner to intermediate level. 
                            Data to be listed in sequence: simple recipe Title, ingredients, estimated time required, steps, estimated calorie.
                            PS: 
                            1. for the recipe title, just output the title without actually writing "recipe title: "
                            2. Same for steps, just display step1, step2, step3 etc according to which step it is.
                            3. Last line of the output must be the estimated calorie')
            ->send($message);

        $recipeTitle = $this->extractRecipeTitle($response);
        $recipeBody = $this->removeFirstLine($response);
        // $this->saveRecipe($recipeTitle, $recipeBody);

        // store the questions in the session for regenerating recipe
        session([
            'question1' => $data['question1'],
            'question2' => $data['question2'],
            'question3' => $data['question3'],
        ]);

        return view('generatedRecipe', ['recipeBody' => $recipeBody, 'recipeTitle' => $recipeTitle, 'recipeID' => null]);
    }
    private function extractRecipeTitle($response) // retrieves recipeTitle by getting first output line
    {
        $line = explode("\n", $response); // assumes first line is recipeTitle
        return $line[0];
    }
    private function removeFirstLine($response)
    {
        $line = explode("\n", $response);
        array_shift($line); // removes first line of array
        return implode("\n", $line);
    }
    public function saveRecipe(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        $recipe = new Recipe();
        $recipe->title = $data['title'];
        $recipe->content = $data['content'];
        $recipe->save();

        return redirect()->route('recipe.list')->with('status', 'Recipe saved successfully!');
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
        return view('viewRecipe', ['recipeBody' => $recipe->content, 'recipeTitle' => $recipe->title]);
    }
    public function listRecipes()
    {
        $recipes = Recipe::all();
        return view('recipeList', ['recipes' => $recipes]);
    }
}
