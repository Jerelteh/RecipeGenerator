<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lemon Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        <h1>Welcome to Lemon</h1>

        <h2>Food Recipes</h2>
        <a href="{{ route('recipe.generator', ['isEditing' => false]) }}">
            <button class="btn btn-success" style="border-radius: 15px">Generate New Recipe</button>
        </a>
        <div>
            @if (session('status'))
                <p>{{ session('status') }}</p>
            @endif
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
    </div>


</body>

</html>
