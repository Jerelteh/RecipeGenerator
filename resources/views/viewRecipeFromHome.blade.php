<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $recipeTitle }}</title>
</head>

<body>
    <h1>{{ $recipeTitle }}</h1>
    <div class="">
        {!! nl2br(e($recipeBody)) !!}
    </div>
    <a href="{{ route('homepage') }}">Back</a>
</body>

</html>
