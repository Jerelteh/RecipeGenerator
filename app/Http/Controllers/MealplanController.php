<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class MealplanController extends Controller
{
    public function showMealplan(Request $request)
    {
        $weekOffset = $request->input('weekOffset', 0);

        // Calculate the start and end of the week
        $currentDate = Carbon::now()->startOfWeek()->addWeeks($weekOffset);
        $weekStart = $currentDate->format('M d, Y');
        $weekEnd = $currentDate->copy()->endOfWeek()->format('M d, Y');

        $days = [
            'Sunday' => $currentDate->copy()->subDay(1)->format('M d'),
            'Monday' => $currentDate->format('M d'),
            'Tuesday' => $currentDate->copy()->addDay(1)->format('M d'),
            'Wednesday' => $currentDate->copy()->addDay(2)->format('M d'),
            'Thursday' => $currentDate->copy()->addDay(3)->format('M d'),
            'Friday' => $currentDate->copy()->addDay(4)->format('M d'),
            'Saturday' => $currentDate->copy()->addDay(5)->format('M d'),
        ];

        return view('mealplan', compact('days', 'weekStart', 'weekEnd', 'weekOffset'));
    }
}
