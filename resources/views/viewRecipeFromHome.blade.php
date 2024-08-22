<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $recipe->title }}</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @include('layouts.sideNavBar')
    <div class="main-content">
        <h1>{{ $recipe->title }}</h1>
        <div class="">
            {!! nl2br(e($recipe->content)) !!}
        </div>
        <div>
            <h4><strong>Estimated Calories: </strong>
                <div class="badge badge-pill badge-secondary">
                    {{ $recipe->calories }}
                </div>
                kcal
            </h4>
        </div>
        <a href="{{ url()->previous() }}" class="btn btn-secondary" style="border-radius: 15px">
            <span class="material-symbols-outlined">
                keyboard_return
            </span>
            Back
        </a>
    </div>

</body>

</html>
