<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Lemon Homepage</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <style>
        .carousel-item img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.5);
            padding: 10px;
            border-radius: 10px;
        }
    </style>
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        <h1>Welcome to Lemon</h1>

        <div id="recipeCarousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                @foreach ($recentRecipes as $index => $recipe)
                    <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                        <img src="{{ $recipe->image_url }}" alt="{{ $recipe->title }}">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $recipe->title }}</h5>
                            <p>{{ $recipe->calories }} kcal</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <a class="carousel-control-prev" href="#recipeCarousel" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#recipeCarousel" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <h2>Food Recipes</h2>
        <a href="{{ route('recipe.generator', ['isEditing' => false]) }}">
            <button class="btn btn-success" style="border-radius: 15px">Generate New Recipe</button>
        </a>
        <div>
            @if (session('status'))
                <p>{{ session('status') }}</p>
            @endif

            @include('layouts.sessionMessage')

            <ul class="list-group">
                @foreach ($recipes as $recipe)
                    <li class="d-flex justify-content-between align-items-center">
                        <div>
                            <a
                                href="{{ route('view.recipe.from.home', ['id' => $recipe->id]) }}">{{ $recipe->title }}</a>
                            <span class="badge badge-pill badge-secondary">{{ $recipe->calories }} kcal</span>
                        </div>

                        {{-- Save to Cookbook button --}}
                        {{-- <div class="btn-group">
                            <button type="button" class="btn btn-warning" data-toggle="modal"
                                style="border-radius: 20px; text-align: center; position: relative;"
                                data-target="#saveRecipeModal{{ $recipe->id }}">+
                            </button>
                        </div> --}}

                        {{-- Save to Saved Recipes button --}}
                        <div>
                            <form action="{{ route('home.saveRecipeFromHome', $recipe->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning"
                                    style="border-radius: 20px; text-align: center;">
                                    +
                                </button>
                            </form>
                        </div>
                    </li>

                    <!-- Save to Cookbook Modal -->
                    <div class="modal fade" id="saveRecipeModal{{ $recipe->id }}" tabindex="-1"
                        aria-labelledby="saveRecipeModalLabel{{ $recipe->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="saveRecipeModalLabel{{ $recipe->id }}">Save to
                                        Cookbook</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form
                                        action="{{ route('cookbooks.addRecipeFromHomepage', ['recipe_id' => $recipe->id]) }}"
                                        method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label for="cookbook">Select Cookbook</label>
                                            <select name="cookbook_id" id="cookbook" class="form-control" required>
                                                @foreach ($cookbooks as $cookbook)
                                                    <option value="{{ $cookbook->id }}">
                                                        {{ $cookbook->title }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
