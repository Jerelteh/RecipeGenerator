<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $tag->name }} Recipes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        <h1>Recipes tagged with "{{ $tag->name }}"</h1>
        @include('layouts.sessionMessage')

        @if ($recipes->isEmpty())
            <p>No recipes found under this category.</p>
        @else
            <!-- Sorting dropdown -->
            <div class="d-flex justify-content-end mb-3">
                <form action="{{ route('sort.by', ['viewType' => 'tag', 'tagID' => $tag->id]) }}" method="GET"
                    id="sortForm">
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
                            <a href="{{ route('view.recipe.from.home', ['id' => $recipe->id]) }}"
                                style="text-decoration: none; color:black">
                                {{ $recipe->title }}
                            </a>
                            <span class="badge badge-pill badge-secondary">{{ $recipe->calories }} kcal</span>
                        </div>
                        {{-- Save to Saved Recipes button --}}
                        @include('partials.saveToSavedRecipesButton')
                    </li>
                @endforeach
            </ul>

            <!-- Pagination links -->
            <div class="mt-3">
                {{ $recipes->links() }}
            </div>
        @endif

        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3" style="border-radius: 15px">Back</a>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </script>
</body>

</html>
