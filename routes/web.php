<?php

use App\Http\Controllers\openaiController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RecipeController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

//////////////////////////////////////////////////////////////////////////////////
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/homepage', [HomeController::class, 'homepage'])->name('homepage');
Route::get('/recipe-from-home/{id}', [HomeController::class, 'viewRecipe'])->name('view.recipe.from.home');

require __DIR__ . '/auth.php';

// Recipe Generation __START__
Route::get('/recipeGenerator', [openaiController::class, 'showRecipeGenerator'])->name('recipe.generator');

Route::post('/submit-input', [openaiController::class, 'submitInput'])->name('submit.input');
// Recipe Generation __END__

// Recipe CRUD __START__
Route::post('/save-recipe', [RecipeController::class, 'saveRecipe'])->name('save.recipe');
Route::get('/recipe-list', [RecipeController::class, 'listRecipes'])->name('recipe.list');
Route::get('/recipe/{id}', [RecipeController::class, 'viewRecipe'])->name('view.recipe');

Route::get('/recipe/{id}/edit', [RecipeController::class, 'editRecipe'])->name('edit.recipe'); // direct to edit recipe (existing)
Route::put('/recipe/{id}', [RecipeController::class, 'updateRecipe'])->name('update.recipe');  // update existing recipe

Route::post('/edit-temp-recipe', [RecipeController::class, 'editTempRecipe'])->name('edit.temp.recipe'); // direct to edit recipe (newly created)
Route::post('update-temp-recipe', [RecipeController::class, 'updateTempRecipe'])->name('update.temp.recipe'); // update temp recipe
Route::delete('/delete-recipe/{id}', [RecipeController::class, 'deleteRecipe'])->name('delete.recipe');
// Recipe CRUD __END__
