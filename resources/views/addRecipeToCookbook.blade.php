<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Recipe to cookbook</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @include('layouts.sideNavBar')
    <div class="main-content">
        <h1>Add recipes to {{ $cookbook->title }}</h1>
        <div class="content-container">
            @if ($userRecipes->isEmpty() && $savedRecipes->isEmpty())
                <p>No Created/Saved Recipes</p>
            @else
                <form action="{{ route('cookbooks.addRecipe', ['cookbook' => $cookbook->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="recipes">Select your Generated Recipe</label>
                        <select name="recipe_ids[]" id="recipes" class="form-control" multiple>
                            {{-- Display user-created recipes --}}
                            @if ($userRecipes->isEmpty())
                                <p>No Created Recipes</p>
                            @else
                                <optgroup label="Generated Recipes">
                                    @foreach ($userRecipes as $recipe)
                                        <option value="{{ $recipe->id }}">
                                            {{ $recipe->title }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="savedRecipes">Select your Saved Recipe</label>
                        <select name="recipe_ids[]" id="savedRecipes" class="form-control" multiple>
                            <!-- Display saved recipes -->
                            @if ($savedRecipes->isEmpty())
                                <p>No Saved Recipes</p>
                            @else
                                <optgroup label="Saved Recipes">
                                    @foreach ($savedRecipes as $savedRecipe)
                                        <option value="{{ $savedRecipe->id }}">
                                            {{ $savedRecipe->title }}
                                        </option>
                                    @endforeach
                                </optgroup>
                            @endif
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Selected Recipes</button>
                </form>
            @endif

            <a href="{{ route('cookbooks.view', $cookbook->id) }}" class="btn btn-secondary mt-3">Back to Cookbook</a>
        </div>

    </div>
</body>

</html>
