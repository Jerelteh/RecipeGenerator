<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cookbook details</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>
    @include('layouts.sideNavBar')
    <div class="main-content">
        <h1 style="font-size: 100px; font-weight:600">{{ $cookbook->title }}
            <small class="badge badge-pill badge-secondary" style="font-size: 50px">{{ $totalCalories }} kcal</small>
        </h1>
        @include('layouts.sessionMessage')

        <div class="content-container">
            <div class="content-header">
                <h2>Recipes in this Cookbook</h2>
            </div>

            @if ($recipes->isEmpty())
                <p>No recipes added yet.</p>
            @else
                <ul style="list-style-type: none">
                    @foreach ($recipes as $recipe)
                        <li>
                            <div class="card my-3">
                                <div class="card-body">
                                    <a href="{{ route('view.recipe', ['id' => $recipe->id]) }}"
                                        style="text-decoration: none; color:black">
                                        <section class="d-flex justify-content-between align-items-center">
                                            <div>
                                                {{ $recipe->title }}
                                                <span class="badge badge-pill badge-secondary">{{ $recipe->calories }}
                                                    kcal</span>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                {{-- Remove Recipe button --}}
                                                <form
                                                    action="{{ route('cookbooks.removeRecipe', [$cookbook->id, $recipe->id]) }}"
                                                    method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger mr-3 d-flex justify-content-center align-items-center">
                                                        <span class="material-symbols-outlined">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </section>
                                    </a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif


            <button type="button" class="btn btn-secondary">
                <a href="{{ route('cookbooks') }}" style="color: white">Back</a>
            </button>
            <!-- Button to add recipes to the cookbook -->
            <a href="{{ route('cookbooks.addRecipeForm', $cookbook->id) }}" class="btn btn-primary">Add Recipe</a>
        </div>

    </div>
</body>

</html>
