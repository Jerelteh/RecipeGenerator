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
    <ul>
        @foreach ($recipes as $recipe)
            <li>
                <strong>{{ $recipe->title }}</strong>
                <form action="{{ route('delete.recipe', $recipe->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>

</html>
