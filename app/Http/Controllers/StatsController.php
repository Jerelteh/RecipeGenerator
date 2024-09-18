<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\SavedRecipe;
use App\Models\Cookbook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class StatsController extends Controller
{
    public function getUserStats()
    {
        $userId = Auth::id();

        // Total number of recipes created by the user
        $userRecipesCount = Recipe::where('user_id', $userId)->count();

        // Total number of saved recipes by the user
        $savedRecipesCount = SavedRecipe::where('user_id', $userId)->count();

        // Total number of cookbooks created by the user
        $userCookbooksCount = Cookbook::where('user_id', $userId)->count();

        // Combine recipe counts
        $totalRecipesCount = $userRecipesCount + $savedRecipesCount;

        return view('dashboard', [
            'totalRecipes' => $totalRecipesCount,
            'totalCookbooks' => $userCookbooksCount,
        ]);
    }
}
