<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BodyFatController extends Controller
{
    public function showCalculator()
    {
        return view('bodyFatCalculator');
    }

    public function calculateBodyFat(Request $request)
    {
        $validated = $request->validate([
            'sex' => 'required|in:male,female',
            'height' => 'required|numeric|min:100',
            'neck' => 'required|numeric|min:25',
            'abdominal' => 'required|numeric|min:23',
        ]);

        $sex = $validated['sex'];
        $height = $validated['height'];
        $neck = $validated['neck'];
        $abdominal = $validated['abdominal'];

        // Check for empty fields
        if (!$request->filled(['sex', 'height', 'neck', 'abdominal'])) {
            return redirect()->back()->with('warning', 'Please fill in all boxes.');
        }
        // Check for minimum values
        if ($request->height < 100 || $request->neck < 25 || $request->abdominal < 23) {
            return redirect()->back()->with('warning', 'The minimum values for height = 100cm, neck = 25cm, and abdominal = 23cm');
        }

        // Body Fat Calculation
        if ($sex === 'male') {
            // Navy Body Fat Formula for males
            $bodyFat = 86.010 * log10($abdominal - $neck) - 70.041 * log10($height) + 36.76;
        } else {
            // Formula for females (with example measurement)
            $bodyFat = 163.205 * log10($abdominal + $neck) - 97.684 * log10($height) - 78.387;
        }

        // Return the result to the same view
        return view('bodyFatCalculator', [
            'bodyFat' => round($bodyFat, 2),
            'bodyFatPercentage' => round($bodyFat, 2) // Pass bodyFatPercentage to the view
        ]);
    }
}
