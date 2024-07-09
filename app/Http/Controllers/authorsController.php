<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class authorsController extends Controller
{
    public function testData()
    {
        return DB::select('select * from authors');
    }
    public function demo($author)
    {
        echo $author;
        echo ', Hello from authors Controller';
        echo '\n';
        return ['name' => $author];
    }

    public function signup(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        Author::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('login')->with('success', 'Account created successfully. Please login.');
    }

    public function submitLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // if (Author::attempt(['email' => $request->email, 'password' => $request->password])) {
        //     return redirect()->intended('dashboard'); // Redirect to intended page
        // } else {
        //     return back()->withErrors([
        //         'email' => 'The provided credentials do not match our records.',
        //     ]);
        // }
    }
}
