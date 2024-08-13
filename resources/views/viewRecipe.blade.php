<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $recipeTitle }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @include('layouts.sideNavBar')
    <div class="main-content">
        {{-- START - recipe details --}}
        <h1>{{ $recipeTitle }}</h1>
        <div class="">
            {!! nl2br($recipeBody) !!}
        </div>
        <div>
            <p><strong>Estimated Calories: </strong>{{ $calories }}</p>
        </div>
        {{-- END - recipe details --}}
        <button type="button" class="btn btn-secondary" onclick="{{ route('recipe.list') }}">Back
        </button>
        <button type="button" class="btn btn-warning" onclick="{{ route('edit.recipe', ['id' => $recipeID]) }}">
            <a href="" style="color: white">Edit Recipe</a>
        </button>
    </div>

</body>

</html>
