<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Food Recipe</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>

<body>
    <div>
        {{-- START - Generated Recipe Output --}}
        <h1>{{ $recipeTitle }}</h1>
        <div class="">
            {!! nl2br($recipeBody) !!}
        </div>
        {{-- START - Generated Recipe Output --}}

        <div>
            {{-- START - save recipe --}}
            <form action="{{ route('save.recipe') }}" method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $recipeTitle }}">
                <input type="hidden" name="content" value="{{ $recipeBody }}">
                <button type="submit">Save Recipe</button>
            </form>
            {{-- END - save recipe --}}

            {{-- START - Regenerate recipe --}}
            <form action="{{ route('submit.input') }}" method="POST">
                @csrf
                <input type="hidden" name="question1" value="{{ session('question1') }}">
                <input type="hidden" name="question2" value="{{ session('question2') }}">
                <input type="hidden" name="question3" value="{{ session('question3') }}">
                <button type="submit">Regenerate Recipe</button>
            </form>
            {{-- END - Regenerate recipe --}}

            {{-- START - To edit recipe  --}}
            <form action="{{ route('edit.temp.recipe') }}" method="POST">
                @csrf
                <input type="hidden" name="title" value="{{ $recipeTitle }}">
                <input type="hidden" name="content" value="{{ $recipeBody }}">
                <button type="submit">Edit Recipe</button>
            </form>
            {{-- END - To edit recipe --}}
        </div>

    </div>

</body>

</html>
