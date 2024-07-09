<?php

use App\Http\Controllers\openaiController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';

// Recipe Generation __START__
Route::get('/recipeGenerator', function () {
    return view('recipeGenerator');
})->name('recipe.generator');
Route::post('/submit-input', [openaiController::class, 'submitInput'])->name('submit.input');
// Recipe Generation __END__