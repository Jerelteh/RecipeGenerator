<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe List</title>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
</head>

<body>
    <h1>Recipe List</h1>
    @if (session('status'))
        <div>{{ session('status') }}</div>
    @endif

    @if ($recipes->isEmpty())
        <p>No Saved Recipes</p>
    @else
        <ul>
            @foreach ($recipes as $recipe)
                <li>
                    <a href="{{ route('view.recipe', ['id' => $recipe->id]) }}">{{ $recipe->title }}</a>
                    <form action="{{ route('delete.recipe', ['id' => $recipe->id]) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    @endif

</body>

</html>
