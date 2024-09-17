<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $recipeTitle }}</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/viewRecipeTags.css') }}">
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        <div class="content-container">
            @include('layouts.sessionMessage')
            <div class="row align-items-center">
                {{-- Recipe Image --}}
                <div class="col-md-6">
                    <div class="recipe-image">
                        @if ($image)
                            <img src="data:image/jpeg;base64,{{ $image }}" alt="Generated Image"
                                class="img-fluid">
                        @else
                            <p>No image available</p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- START - recipe details --}}
            <!-- Recipe Title -->
            <span class="recipe-title">
                <h1>
                    {{ $recipeTitle }}
                    <!-- Share Button -->
                    <button type="button" class="btn btn-light" data-toggle="modal" data-target="#shareModal"
                        style="border-radius: 15px; padding-top: 13px;">
                        <span class="material-symbols-outlined">
                            share
                        </span>
                    </button>
                </h1>
            </span>

            <!-- Include the Share Modal -->
            @include('partials.shareRecipeModal')

            <div class="recipe-details">
                <!-- Display existing tags -->
                <div class="mt-3">
                    <h5>Tags:</h5>
                    <ul id="tagList">
                        @foreach ($tags as $tag)
                            <li class="tag-btn">
                                {{ $tag->name }}
                                <span class="remove-tag"
                                    onclick="event.preventDefault(); document.getElementById('remove-tag-{{ $tag->id }}').submit();">
                                    &times;
                                </span>
                                <form id="remove-tag-{{ $tag->id }}"
                                    action="{{ route('recipes.removeTag', ['recipeID' => $recipeID, 'tagID' => $tag->id]) }}"
                                    method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <!-- Button to trigger the Tag Modal -->
                <button type="button" class="btn btn-secondary" data-toggle="modal" data-target="#tagModal"
                    style="border-radius: 15px">
                    Add Tags
                </button>
                <div>
                    {!! nl2br($recipeBody) !!}
                </div>

                <div>
                    <h4><strong>Estimated Calories: </strong>
                        <div class="badge badge-pill badge-secondary">
                            <div class="display-calorie-badge">
                                {{ $calories }}
                            </div>
                        </div>
                        kcal
                    </h4>
                </div>
            </div>
            {{-- END - recipe details --}}

            <button type="button" class="btn btn-secondary" onclick="{{ route('recipe.list') }}"
                style="border-radius: 15px">Back
            </button>
            <button type="button" class="btn btn-warning" onclick="{{ route('edit.recipe', ['id' => $recipeID]) }}"
                style="border-radius: 15px">
                <a href="" style="color: white">Edit Recipe</a>
            </button>

            {{-- tags button modal --}}
            <div class="modal fade" id="tagModal" tabindex="-1" role="dialog" aria-labelledby="tagModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tagModalLabel">Add Tags</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form id="tagForm" method="POST"
                                action="{{ route('recipes.addTags', ['recipeID' => $recipeID]) }}">
                                @csrf
                                <div class="form-group">
                                    <label for="tags">Select Tags:</label>
                                    <select name="tags[]" id="tags" class="form-control" multiple required>
                                        @foreach ($allTags as $tag)
                                            <option value="{{ $tag }}">{{ $tag }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Tag</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6Hty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
</body>

</html>
