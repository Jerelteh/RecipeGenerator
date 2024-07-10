<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $recipeTitle }}</title>
</head>

<body>
    {{-- START - recipe details --}}
    <h1>{{ $recipeTitle }}</h1>
    <div class="">
        {!! nl2br($recipeBody) !!}
    </div>
    {{-- END - recipe details --}}
    <a href="{{ route('recipe.list') }}">Back to Recipe List</a>
</body>

</html>
