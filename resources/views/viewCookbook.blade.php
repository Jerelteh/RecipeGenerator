<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cookbook details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @include('layouts.sideNavBar')
    <div class="main-content">
        <h1 style="font-size: 100px; font-weight:600">{{ $cookbook->title }}
            <small class="badge badge-pill badge-secondary" style="font-size: 50px">{{ $totalCalories }} kcal</small>
        </h1>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif


        <h2>Recipes in this Cookbook</h2>

        @if ($recipes->isEmpty())
            <p>No recipes added yet.</p>
        @else
            <ul>
                @foreach ($recipes as $recipe)
                    <a href="{{ route('view.recipe', ['id' => $recipe->id]) }}">
                        <li>{{ $recipe->title }}</li>
                        <span class="badge badge-pill badge-secondary">{{ $recipe->calories }} kcal</span>
                    </a>

                    {{-- Remove Recipe button --}}
                    <form action="{{ route('cookbooks.removeRecipe', [$cookbook->id, $recipe->id]) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                    </form>
                @endforeach
            </ul>
        @endif


        <button type="button" class="btn btn-secondary">
            <a href="{{ route('cookbooks') }}" style="color: white">Back</a>
        </button>
        <!-- Button to add recipes to the cookbook -->
        <a href="{{ route('cookbooks.addRecipeForm', $cookbook->id) }}" class="btn btn-primary">Add Recipe</a>
    </div>
</body>

</html>
