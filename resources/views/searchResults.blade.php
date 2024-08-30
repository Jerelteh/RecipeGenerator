<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        <h1>Search Results for "{{ $query }}"</h1>
        @include('layouts.sessionMessage')
        @if ($recipes->isEmpty())
            <p>No recipes found.</p>
        @else
            <div class="d-flex justify-content-end mb-3">
                <form action="{{ route('sort.by', ['viewType' => 'search']) }}" method="GET" id="sortForm">
                    <input type="hidden" name="query" value="{{ request()->input('query') }}">
                    <select name="sort" class="custom-select"
                        onchange="document.getElementById('sortForm').submit();">
                        <option value="newest" {{ request()->input('sort') == 'newest' ? 'selected' : '' }}>Newest to
                            Oldest</option>
                        <option value="oldest" {{ request()->input('sort') == 'oldest' ? 'selected' : '' }}>Oldest to
                            Newest</option>
                        <option value="highest" {{ request()->input('sort') == 'highest' ? 'selected' : '' }}>Highest to
                            Lowest Calories</option>
                        <option value="lowest" {{ request()->input('sort') == 'lowest' ? 'selected' : '' }}>Lowest to
                            Highest Calories</option>
                    </select>
                </form>
            </div>
            <ul class="list-group">
                @foreach ($recipes as $recipe)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <a
                                href="{{ route('view.recipe.from.home', ['id' => $recipe->id]) }}">{{ $recipe->title }}</a>
                            <span class="badge badge-pill badge-secondary">{{ $recipe->calories }} kcal</span>
                        </div>
                        {{-- Save to Saved Recipes button --}}
                        @include('partials.saveToSavedRecipesButton')
                    </li>
                @endforeach
            </ul>
        @endif
    </div>

</body>

</html>
