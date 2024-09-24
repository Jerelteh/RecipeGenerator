<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Tag;

class SortController extends Controller
{
    public function sortBy(Request $request, $viewType, $tagID = null)
    {
        // Determine sort order and criteria
        $sortType = $request->input('sort');
        $sortOrder = $sortType == 'newest' || $sortType == 'highest' ? 'desc' : 'asc';
        $sortField = $sortType == 'lowest' || $sortType == 'highest' ? 'calories' : 'created_at';

        // Get the recipes based on view type
        if ($viewType == 'search') {
            $searchQuery = $request->input('query');
            $recipes = Recipe::where('title', 'LIKE', "%$searchQuery%")
                ->orderBy($sortField, $sortOrder)
                ->get();
            return view('searchResults', compact('recipes'));
        } elseif ($viewType == 'tag') {
            $tag = Tag::findOrFail($tagID);
            $recipes = $tag->recipes()->orderBy($sortField, $sortOrder)->paginate(10);

            return view('recipesByTag', [
                'recipes' => $recipes,
                'tag' => $tag,
            ]);
        }
    }
}
