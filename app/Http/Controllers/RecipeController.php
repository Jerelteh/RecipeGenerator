<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Tag;
use App\Models\SavedRecipe;
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
            'image' => 'nullable|string',
        ]);

        $recipe = new Recipe();
        $recipe->title = $data['title'];
        $recipe->content = $data['content'];
        $recipe->calories = $data['calories'];
        // Check if 'image' is set and decode it before saving
        // if (!empty($data['image'])) {
        //     $recipe->image = base64_decode($data['image']); // Decode the base64 string to binary
        // }
        if (!empty($data['image'])) {
            $recipe->image = $data['image'];
        }
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

        return redirect()->route('view.recipe', ['id' => $recipe->id])->with('success', 'Recipe saved successfully!');
    }
    public function overwriteRecipe(Request $request, $recipeID)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
            'calories' => 'required|integer',
            'image' => 'nullable|string',
        ]);

        $recipe = Recipe::findOrFail($recipeID);
        $recipe->title = $data['title'];
        $recipe->content = $data['content'];
        $recipe->calories = $data['calories'];
        $recipe->image = $data['image'];
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
        return redirect()->route('recipe.list')->with('success', 'Recipe overwritten successfully!');
    }
    public function deleteRecipe(int $recipeID)
    {
        $recipe = Recipe::findOrFail($recipeID);
        $recipe->delete();

        return redirect()->route('recipe.list')->with('success', 'Recipe deleted successfully!');
    }
    public function viewRecipe($recipeID)
    {
        $recipe = Recipe::findOrFail($recipeID);
        $tags = $recipe->tags;

        return view('viewRecipe', [
            'recipeBody' => $recipe->content,
            'recipeTitle' => $recipe->title,
            'calories' => $recipe->calories,
            'image' => $recipe->image,
            'recipeID' => $recipe->id,
            'tags' => $tags, // pass the collection of tag objects
            'allTags' => Tag::all()->pluck('name', 'id'), // fetch all available tags
        ]);
    }
    public function listRecipes()
    {
        // Fetch recipes from recipes table for the logged-in user with pagination
        $userRecipes = Recipe::where('user_id', Auth::id())->paginate(10);

        // Fetch recipes from saved_recipes table for the logged-in user with pagination
        $savedRecipes = SavedRecipe::where('user_id', Auth::id())->paginate(10);

        return view('recipeList', [
            'userRecipes' => $userRecipes,
            'savedRecipes' => $savedRecipes,
        ]);
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

        return redirect()->route('view.recipe', ['id' => $recipe->id])->with('success', 'Recipe updated successfully!');
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
    public function destroySavedRecipe($id)
    {
        // Find the saved recipe by ID and ensure it belongs to the authenticated user
        $savedRecipe = SavedRecipe::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if ($savedRecipe) {
            $savedRecipe->delete();
            return redirect()->back()->with('success', 'Saved recipe deleted successfully!');
        } else {
            // If not found or doesn't belong to the user, return a 404 response
            abort(404, 'Saved recipe not found.');
        }
    }
    public function addTags(Request $request, $recipeID)
    {
        $recipe = Recipe::findOrFail($recipeID);

        // Get the selected tag names from the request
        $selectedTag = $request->input('tags', []);
        // Retrieve the Tag IDs based on the selected tag names
        $tagIDs = Tag::whereIn('name', $selectedTag)->pluck('id')->toArray();

        // Filter out tags that are already attached to the recipe
        $existingTagIDs = $recipe->tags()->pluck('tags.id')->toArray();
        $newTagIDs = array_diff($tagIDs, $existingTagIDs);

        if (empty($newTagIDs)) { // If tag already exist, redirect with a warning
            return redirect()->route('view.recipe', ['id' => $recipeID])
                ->with('warning', 'Selected tag already exist in the recipe.');
        }

        // Attach only the new tags to the recipe
        $recipe->tags()->attach($newTagIDs);

        return redirect()->route('view.recipe', ['id' => $recipeID])
            ->with('success', 'Tag added successfully!');
    }
    public function recipesByTag($tag)
    {
        // Fetch the tag by its ID or name
        $tag = Tag::where('id', $tag)->orWhere('name', $tag)->firstOrFail();

        // Fetch recipes that have the selected tag
        $recipes = $tag->recipes()->paginate(10);

        return view('recipesByTag', [
            'recipes' => $recipes,
            'tag' => $tag,
        ]);
    }
    public function removeTag(Request $request, $recipeID, $tagID)
    {
        $recipe = Recipe::findOrFail($recipeID);
        $recipe->tags()->detach($tagID);
        return redirect()->route('view.recipe', ['id' => $recipeID])->with('success', 'Tag removed successfully!');
    }
    private function clearRecipeSession() // clears session values
    {
        session()->forget(['question1', 'question2', 'question3', 'question4', 'question5', 'image_url']);
    }
}
