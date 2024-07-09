<?php

namespace App\Http\Controllers;

use App\AI\Chat;
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
                            PS: for the recipe title, just output the title without actually writing "recipe title: ", 
                            Same for steps, just display step1, step2, step3 etc according to which step it is.')
            ->send($message);

        $recipeTitle = $this->extractRecipeTitle($response);
        $recipeBody = $this->removeFirstLine($response);

        return view('generatedRecipe', ['recipeBody' => $recipeBody, 'recipeTitle' => $recipeTitle]);
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
