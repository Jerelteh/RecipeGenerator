<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lemon Homepage</title>
</head>

<body>
    <h1>Welcome to Lemon</h1>

    <h2>Food Recipes</h2>
    <a href="{{ route('recipe.generator') }}">
        <button>Generate New Recipe</button>
    </a>
    <div>
        {{-- @if (session('status'))
            <p>{{ session('status') }}</p>
        @endif --}}
        <ul>
            @foreach ($recipes as $recipe)
                <li>
                    <a href="{{ route('view.recipe.from.home', ['id' => $recipe->id]) }}">{{ $recipe->title }}</a>
                    <form action="{{ route('delete.recipe', ['id' => $recipe->id]) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>

</body>

</html>
