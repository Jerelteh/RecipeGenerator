<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function showAnalytics(Request $request)
    {
        $userId = Auth::id();
        $currentMonth = $request->input('month', Carbon::now()->format('Y-m'));
        $startOfMonth = Carbon::parse($currentMonth)->startOfMonth();
        $endOfMonth = Carbon::parse($currentMonth)->endOfMonth();

        // Fetch the recipes created by the user within the selected month
        $recipes = Recipe::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->get();

        // Calculate the total number of recipes generated in the current month
        $totalRecipesThisMonth = Recipe::where('user_id', $userId)
            ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
            ->count();

        // Format data for Chart.js
        $dates = [];
        $counts = [];

        foreach ($recipes as $recipe) {
            $dates[] = $recipe->date;
            $counts[] = $recipe->count;
        }

        return view('analytics', [
            'dates' => $dates,
            'counts' => $counts,
            'currentMonth' => $currentMonth,
            'totalRecipesThisMonth' => $totalRecipesThisMonth,
        ]);
    }
}
