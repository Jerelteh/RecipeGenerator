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
        <h1>{{ $recipeTitle }}</h1>
        {{-- START - Generated Recipe Output --}}
        <div class="">
            {!! nl2br($recipeBody) !!}
        </div>
        {{-- START - Generated Recipe Output --}}
    </div>

</body>

</html>
