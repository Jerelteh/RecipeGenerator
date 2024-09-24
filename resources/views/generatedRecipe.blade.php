<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Food Recipe</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        <div class="content-container">
            <div class="row align-items-center">
                {{-- Recipe Image --}}
                @if (isset($image))
                    <div class="col-md-6">
                        <div class="recipe-image">
                            <img src="data:image/jpeg;base64,{{ base64_encode($image) }}" alt="Generated Image"
                                class="img-fluid">
                        </div>
                    </div>
                @endif
            </div>

            {{-- START - Generated Recipe Output --}}
            <span class="recipe-title">
                <h1>
                    {{ $recipeTitle }}
                </h1>
            </span>
            <div class="recipe-details">
                <div>
                    {!! nl2br($recipeBody) !!}
                </div>
                <div>
                    <p><strong>Estimated Calories: </strong>
                        <span class="badge badge-pill badge-secondary">
                            {{ $calories }}
                        </span>
                    </p>
                </div>
            </div>
            {{-- END - Generated Recipe Output --}}

            <div>
                {{-- START - save recipe --}}
                <form action="{{ route('save.recipe') }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{ $recipeTitle }}">
                    <input type="hidden" name="content" value="{{ $recipeBody }}">
                    <input type="hidden" name="calories" value="{{ $calories }}">
                    <input type="hidden" name="image" value="{{ base64_encode($image) }}">
                    <button type="submit" class="btn btn-success">Save Recipe</button>
                </form>
                {{-- END - save recipe --}}

                {{-- START - Regenerate recipe --}}
                <form action="{{ route('recipe.generator') }}" method="GET">
                    @csrf
                    <input type="hidden" name="question1" value="{{ session('question1') }}">
                    <input type="hidden" name="question2" value="{{ session('question2') }}">
                    <input type="hidden" name="question3" value="{{ session('question3') }}">
                    <input type="hidden" name="question4" value="{{ session('question4') }}">
                    <input type="hidden" name="question5" value="{{ session('question5') }}">
                    <input type="hidden" name="recipeID" value="{{ $recipeID }}">
                    <input type="hidden" name="isEditing" value="{{ $isEditing }}">
                    <button type="submit" class="btn btn-warning">Regenerate Recipe</button>
                </form>
                {{-- END - Regenerate recipe --}}

                {{-- START - To edit recipe  --}}
                <form action="{{ route('edit.temp.recipe') }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{ $recipeTitle }}">
                    <input type="hidden" name="content" value="{{ $recipeBody }}">
                    <input type="hidden" name="calories" value="{{ $calories }}">
                    <input type="hidden" name="recipeID" value="{{ $recipeID }}">
                    <input type="hidden" name="isEditing" value="{{ $isEditing }}">
                    <button type="submit" class="btn btn-light">Edit Recipe</button>
                </form>
                {{-- END - To edit recipe --}}

                {{-- START - Overwrite Existing Recipe --}}
                @if (isset($isEditing) && $isEditing && isset($recipeID))
                    <form action="{{ route('overwrite.recipe', ['id' => $recipeID]) }}" method="POST">
                        @csrf
                        <input type="hidden" name="title" value="{{ $recipeTitle }}">
                        <input type="hidden" name="content" value="{{ $recipeBody }}">
                        <input type="hidden" name="calories" value="{{ $calories }}">
                        <input type="hidden" name="image" value="{{ base64_encode($image) }}">
                        <button type="submit">Overwrite Existing Recipe</button>
                    </form>
                @endif
                {{-- END - Overwrite Existing Recipe --}}
            </div>
        </div>
    </div>

</body>

</html>
