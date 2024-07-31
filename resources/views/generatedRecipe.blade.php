<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Food Recipe</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="sideBarNavStyle.css">
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        {{-- START - Generated Recipe Output --}}
        <h1>{{ $recipeTitle }}</h1>
        <div class="">
            {!! nl2br($recipeBody) !!}
        </div>
        <div>
            <p><strong>Estimated Calories: </strong>{{ $calories }}</p>
        </div>
        {{-- START - Generated Recipe Output --}}

        <div>
            {{-- START - save recipe --}}
            <form action="{{ route('save.recipe') }}" method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $recipeTitle }}">
                <input type="hidden" name="content" value="{{ $recipeBody }}">
                <input type="hidden" name="calories" value="{{ $calories }}">
                <button type="submit">Save Recipe</button>
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
                <button type="submit">Regenerate Recipe</button>
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
                <button type="submit">Edit Recipe</button>
            </form>
            {{-- END - To edit recipe --}}

            {{-- START - Overwrite Existing Recipe --}}
            @if (isset($isEditing) && $isEditing && isset($recipeID))
                <form action="{{ route('overwrite.recipe', ['id' => $recipeID]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="title" value="{{ $recipeTitle }}">
                    <input type="hidden" name="content" value="{{ $recipeBody }}">
                    <input type="hidden" name="calories" value="{{ $calories }}">
                    <button type="submit">Overwrite Existing Recipe</button>
                </form>
            @endif
            {{-- END - Overwrite Existing Recipe --}}
        </div>

    </div>

</body>

</html>
