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
        <h1>Your Recipes</h1>
        @include('layouts.sessionMessage')

        <div class="content-container">
            <div class="content-header">
                <h2>Created Recipes</h2>
            </div>

            @if ($userRecipes->isEmpty())
                <p>No Saved Recipes</p>
            @else
                <ul>
                    @foreach ($userRecipes as $userRecipe)
                        <li>
                            <div>
                                <a
                                    href="{{ route('view.recipe', ['id' => $userRecipe->id]) }}">{{ $userRecipe->title }}</a>
                                <span class="badge badge-pill badge-secondary">{{ $userRecipe->calories }} kcal</span>
                            </div>

                            <form action="{{ route('recipe.generator.from.list', ['id' => $userRecipe->id]) }}"
                                method="GET">
                                @csrf
                                <input type="hidden" name="isEditing" value="1">
                                <button type="submit" class="btn btn-success">
                                    <span class="material-symbols-outlined">
                                        autorenew
                                    </span>
                                    {{-- <div>Regenerate</div> --}}
                                </button>
                            </form>
                            <form action="{{ route('delete.recipe', ['id' => $userRecipe->id]) }}" method="POST"
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

                {{-- Pagination for created recipes --}}
                {{ $userRecipes->links() }}
            @endif
        </div>

        {{-- Recipes for saved recipes --}}
        <div class="content-container">
            <div class="container-header">
                <h2>Saved Recipes</h2>
            </div>

            @if ($savedRecipes->isEmpty())
                <p>No Saved Recipes</p>
            @else
                <ul>
                    @foreach ($savedRecipes as $savedRecipe)
                        <li>
                            <div>
                                <a href="{{ route('view.recipe', ['id' => $savedRecipe->recipe->id]) }}">
                                    {{ $savedRecipe->recipe->title }}
                                </a>
                                <span class="badge badge-pill badge-secondary">{{ $savedRecipe->recipe->calories }}
                                    kcal</span>
                            </div>

                            <form action="{{ route('delete.saved.recipe', ['id' => $savedRecipe->id]) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <span class="material-symbols-outlined">delete</span>
                                </button>
                            </form>
                        </li>
                    @endforeach
                </ul>

                {{-- Pagination for saved recipes --}}
                {{ $savedRecipes->links() }}
            @endif
        </div>
    </div>
</body>

</html>
