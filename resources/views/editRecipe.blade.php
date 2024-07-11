<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Recipe</title>
</head>

<body>
    <h1>Edit Recipe</h1>
    <div>
        <form action="{{ route('update.recipe', ['id' => $recipe->id]) }}" method="POST">
            @csrf
            @method('PUT')
            <div>
                <label for="title">Recipe Title:</label>
                <input type="text" id="title" name="title" value="{{ $recipe->title }}" required>
            </div>
            <div>
                <label for="content">Recipe Content:</label>
                <textarea id="content" name="content" rows="10" required>{{ $recipe->content }}</textarea>
            </div>
            <button type="submit">Update Recipe</button>
        </form>
    </div>
    <a href="{{ route('view.recipe', ['id' => $recipe->id]) }}">Cancel</a>
</body>

</html>
