<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        <h1>Your Recipes (Recipe List)</h1>
        @if (session('status'))
            <div>{{ session('status') }}</div>
        @endif

        @if ($recipes->isEmpty())
            <p>No Saved Recipes</p>
        @else
            <ul>
                @foreach ($recipes as $recipe)
                    <li>
                        <div>
                            <a href="{{ route('view.recipe', ['id' => $recipe->id]) }}">{{ $recipe->title }}</a>
                            <span class="badge badge-pill badge-secondary">{{ $recipe->calories }} kcal</span>
                        </div>

                        <form action="{{ route('recipe.generator.from.list', ['id' => $recipe->id]) }}" method="GET">
                            @csrf
                            <input type="hidden" name="isEditing" value="1">
                            <button type="submit" class="btn btn-success">
                                <span class="material-symbols-outlined">
                                    autorenew
                                </span>
                                {{-- <div>Regenerate</div> --}}
                            </button>
                        </form>
                        <form action="{{ route('delete.recipe', ['id' => $recipe->id]) }}" method="POST"
                            style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <span class="material-symbols-outlined">
                                    delete
                                </span>
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</body>

</html>
