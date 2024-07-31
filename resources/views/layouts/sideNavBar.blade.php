<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Side Navigation Bar</title>
    {{-- linking google font link for icons --}}
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/sideNavBarStyle.css') }}">
</head>

<body>
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="{{ asset('images/logo.png') }}" alt="logo">
            <h2>Lemon</h2>
        </div>
        <ul class="sidebar-links">

            <h4><span>Main Menu</span></h4>
            <div class="menu-separator"></div>

            <li>
                <a href="{{ route('recipe.generator', ['isEditing' => false]) }}">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                    <div class="generate-recipe-button">Generate Recipe</div>
                </a>
            </li>
            <li>
                <a href="{{ route('homepage') }}">
                    <span class="material-symbols-outlined">
                        home
                    </span>Homepage</a>
            </li>

            <h4><span>General</span></h4>
            <div class="menu-separator"></div>

            <li>
                <a href="#"><span class="material-symbols-outlined">
                        calendar_month
                    </span>Meal Planner</a>
            </li>
            <li>
                <a href="#"><span class="material-symbols-outlined">
                        menu_book
                    </span>Cookbooks</a>
            </li>
            <li>
                <a href="{{ route('recipe.list') }}">
                    <span class="material-symbols-outlined">
                        restaurant
                    </span>Saved Recipes</a>
            </li>

            <h4><span>Account</span></h4>
            <div class="menu-separator"></div>

            <li>
                <a href="{{ route('dashboard') }}"><span class="material-symbols-outlined">
                        account_circle
                    </span>Profile</a>
            </li>
            <li>
                <a href="#"><span class="material-symbols-outlined">
                        settings
                    </span>Settings</a>
            </li>
            <li>
                <a href="#"><span class="material-symbols-outlined">
                        logout
                    </span>Logout</a>
            </li>
        </ul>
        <div class="user_account">
            <div class="user-profile">
                <span class="material-symbols-outlined">face</span>
                <div class="user-detail">
                    <h3>{{ Auth::user()->name }}</h3>
                    <span>{{ Auth::user()->role ?? 'User' }}</span>
                </div>
            </div>
        </div>
    </aside>
</body>

</html>
