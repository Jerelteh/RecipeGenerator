<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Add Recipe to cookbook</title>
</head>

<body>
    <div class="main-content">
        <h1>Add recipes to {{ $cookbook->title }}</h1>

        @if ($recipes->isEmpty())
            <p>No Saved Recipes</p>
        @else
            <form action="{{ route('cookbooks.addRecipe', ['cookbook' => $cookbook->id]) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="recipes">Select Recipe</label>
                    <select name="recipe_ids[]" id="recipes" class="form-control" multiple>
                        @foreach ($recipes as $recipe)
                            <option value="{{ $recipe->id }}">
                                {{ $recipe->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Add Selected Recipes</button>
            </form>
        @endif

        <a href="{{ route('cookbooks.view', $cookbook->id) }}" class="btn btn-secondary mt-3">Back to Cookbook</a>
    </div>
</body>

</html>
