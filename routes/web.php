<?php

use App\Http\Controllers\openaiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CookbookController;
use App\Http\Controllers\MealplanController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SortController;
use App\Http\Controllers\AnalyticsController;
use App\Http\Controllers\BodyFatController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Models\Cookbook;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// for sideNavBar testing
Route::get('/sideNavBar', function () {
    return view('/layouts/sideNavBar');
})->name('sideNavBar');

//////////////////////////////////////////////////////////////////////////////////

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::get('/homepage', [HomeController::class, 'homepage'])->name('homepage');
Route::get('/recipe-from-home/{id}', [HomeController::class, 'viewRecipeFromHome'])->name('view.recipe.from.home');
Route::post('/save-recipe/{recipe_id}', [HomeController::class, 'saveRecipeFromHome'])->name('home.saveRecipeFromHome'); // saves homepage recipes to table saved_recipes
Route::delete('/saved-recipes/{id}', [RecipeController::class, 'destroySavedRecipe'])->name('delete.saved.recipe');

require __DIR__ . '/auth.php';

// Recipe Generation __START__
Route::get('/recipeGenerator', [openaiController::class, 'showRecipeGenerator'])->name('recipe.generator');
Route::get('/recipeGenerator/from-list/{id}', [openaiController::class, 'regenerateFromList'])->name('recipe.generator.from.list');
Route::post('/submit-input', [openaiController::class, 'submitInput'])->name('submit.input');
// Recipe Generation __END__

// Recipe CRUD __START__
Route::post('/save-recipe', [RecipeController::class, 'saveRecipe'])->name('save.recipe');
Route::post('overwrite-recipe/{id}', [RecipeController::class, 'overwriteRecipe'])->name('overwrite.recipe'); // overwrites/updates existing recipe
Route::get('/recipe-list', [RecipeController::class, 'listRecipes'])->name('recipe.list');
Route::get('/recipe/{id}', [RecipeController::class, 'viewRecipe'])->name('view.recipe');

Route::get('/recipe/{id}/edit', [RecipeController::class, 'editRecipe'])->name('edit.recipe'); // direct to edit recipe (existing)
Route::put('/recipe/{id}', [RecipeController::class, 'updateRecipe'])->name('update.recipe');  // update existing recipe

Route::post('/edit-temp-recipe', [RecipeController::class, 'editTempRecipe'])->name('edit.temp.recipe'); // direct to edit recipe (newly created)
Route::post('update-temp-recipe', [RecipeController::class, 'updateTempRecipe'])->name('update.temp.recipe'); // update temp recipe
Route::delete('/delete-recipe/{id}', [RecipeController::class, 'deleteRecipe'])->name('delete.recipe');
// Recipe CRUD __END__

// Recipe Tags
Route::post('/recipes/{recipeID}/addTags', [RecipeController::class, 'addTags'])->name('recipes.addTags');
Route::delete('/recipes/{recipeID}/tags/{tagID}', [RecipeController::class, 'removeTag'])->name('recipes.removeTag');

// Cookbook __START__
Route::middleware(['auth'])->group(function () {
    Route::get('/cookbooks', [CookbookController::class, 'listCookbooks'])->name('cookbooks');
    Route::get('/cookbooks/create', [CookbookController::class, 'createCookbook'])->name('cookbooks.create');
    Route::post('/cookbookSubmit', [CookbookController::class, 'saveCookbook'])->name('cookbooks.save');
    Route::delete('/cookbooks/{cookbook}', [CookbookController::class, 'deleteCookbook'])->name('cookbooks.delete');

    // View Cookbook details
    Route::get('/cookbooks/{cookbook}', [CookbookController::class, 'viewCookbook'])->name('cookbooks.view');
    // Add recipes to Cookbook
    Route::get('/cookbooks/{cookbook}/add-recipe', [CookbookController::class, 'addRecipeForm'])->name('cookbooks.addRecipeForm');
    Route::post('/cookbooks/{cookbook}/add-recipe', [CookbookController::class, 'addRecipe'])->name('cookbooks.addRecipe');
    Route::post('/cookbooks/add-recipe-homepage', [CookbookController::class, 'addRecipeFromHomepage'])->name('cookbooks.addRecipeFromHomepage');
    // Remove recipes from Cookbook
    Route::delete('/cookbooks/{cookbook}/remove-recipe/{recipe}', [CookbookController::class, 'removeRecipe'])->name('cookbooks.removeRecipe');
});
// Cookbook __END__

// Mealplan __START__
Route::get('/mealplan', [MealplanController::class, 'showMealplan'])->name('mealplan');
// Mealplan __END__

// Tags __START__
Route::get('/recipes/tag/{tag}', [RecipeController::class, 'recipesByTag'])->name('recipes.byTag');
// Tags __END__

// Recipe Search Bar __START__
Route::get('/search-suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');
Route::get('/search', [SearchController::class, 'search'])->name('search.recipes');
// Recipe Search Bar __END__

// Recipe Sort __START__
Route::get('/sort/{viewType}/{tagID?}', [SortController::class, 'sortBy'])->name('sort.by');
// Recipe Sort __END__

// Analytics __START__
Route::get('/analytics', [AnalyticsController::class, 'showAnalytics'])->name('analytics');
// Analytics __END__

// BodyFat __START__
Route::get('/body-fat-calculator', [BodyFatController::class, 'showCalculator'])->name('body.fat.calculator');
Route::post('/body-fat-calculator', [BodyFatController::class, 'calculateBodyFat'])->name('body.fat.calculate');
// BodyFat __END__