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
            'question1' => 'nullable|string|max:200',
            'question2' => 'nullable|string',
            'question3' => 'nullable|string',
            'question4' => 'nullable|integer|max:1440',
            'question5' => 'required|string',
        ]);

        $input = new Chat();
        $message = "Ingredients on-hand: {$data['question1']}\n
                    Available Food Preparation Appliances: {$data['question2']}\n
                    Available Kitchen Appliances for Cooking: {$data['question3']}\n
                    Preferred Time(mins): {$data['question4']}\n
                    Cooking Skill Level: {$data['question5']}";
        $response = $input
            ->systemMessage('You are a text to recipe generator. You will generate the following things accordingly: 
                            detailed but short steps, ingredients used, estimated completion time, estimated calorie. 
                            Recipe should cater to novice cooking skill level by default unless specified.
                            If preferred time is not provided by user, an estimated time must be provided.
                            If Cooking skill is advanced, add extra ingredients and steps, if PRO cooking skill, add even more on top of advanced.
                            Data to be listed in sequence: simple recipe Title, ingredients, estimated time required, steps, estimated calorie.
                            PS: 
                            1. for the recipe title, just output the title without actually writing "recipe title: "
                            2. Same for steps, just display step1, step2, step3 etc according to which step it is.
                            3. Last line of the output must be the estimated calorie')
            ->send($message);

        $recipeTitle = $this->extractRecipeTitle($response);
        $recipeBody = $this->removeFirstLine($response);

        // store the questions in the session for regenerating recipe
        session([
            'question1' => $data['question1'],
            'question2' => $data['question2'],
            'question3' => $data['question3'],
            'question4' => $data['question4'],
            'question5' => $data['question5'],
        ]);

        return view('generatedRecipe', [
            'recipeBody' => $recipeBody,
            'recipeTitle' => $recipeTitle,
            'recipeID' => $request->input('recipeID'), // Pass in recipeID if exists
            'isEditing' => $request->input('isEditing', false)
        ]);
    }
    public function showRecipeGenerator(Request $request)
    {
        return view('recipeGenerator', [
            'question1' => session('question1', ''),
            'question2' => session('question2', ''),
            'question3' => session('question3', ''),
            'question4' => session('question4', ''),
            'question5' => session('question5', ''),
            'isEditing' => $request->input('isEditing', false)
        ]);
    }
    public function regenerateFromList(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);
        $input = $recipe->inputs; // Retrieve input values

        return view('recipeGenerator', [
            'recipeID' => $recipe->id,
            'question1' => $input->question1,
            'question2' => $input->question2,
            'question3' => $input->question3,
            'question4' => $input->question4,
            'question5' => $input->question5,
            'isEditing' => true
        ]);
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
}
