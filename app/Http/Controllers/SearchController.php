<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $query = $request->input('query');
        $recipes = Recipe::where('title', 'like', "%{$query}%")->limit(5)->get(['id', 'title']);
        return response()->json($recipes);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $recipes = Recipe::where('title', 'like', "%{$query}%")->paginate(10);
        return view('searchResults', compact('recipes', 'query'));
    }
}
