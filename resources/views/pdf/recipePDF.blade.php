<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>{{ $recipe->title }} - PDF</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nerko+One&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: sans-serif;
        }

        .title {
            font-size: 24px;
            font-weight: bold;
        }

        .calories {
            margin-top: 10px;
        }

        .content {
            margin-top: 20px;
        }

        h1 {
            font-family: 'Nerko One', cursive;
            font-weight: 400;
            font-style: normal;
            margin-top: 30px;
            margin-bottom: 30px;
            font-size: 100px;
        }
    </style>
</head>

<body>
    <div class="title">
        <h1>{{ $recipe->title }}</h1>
    </div>

    {{-- <div>
        @if ($recipe->image)
            <img src="data:image/jpeg;base64,{{ $recipe->image }}" alt="Recipe Image" style="width: 100%; height: auto;">
        @else
            <p>No image available</p>
        @endif
    </div> --}}

    <div class="tags">
        <h4>Tags:</h4>
        <ul>
            @foreach ($tags as $tag)
                <li>{{ $tag->name }}</li>
            @endforeach
        </ul>
    </div>

    <div class="content">
        {!! nl2br($recipe->content) !!}
    </div>

    <div class="calories">
        <strong>Calories:</strong> {{ $recipe->calories }} kcal
    </div>


</body>

</html>
