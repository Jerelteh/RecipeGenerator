<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recipe Generator</title>
</head>

<body>
    <div>
        <h1>Generate a Recipe</h1>
        <form action="{{ route('submit.input') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="question1">1. What ingredients do you have on hand?</label>
                <input type="text" class="form-control" id="question1" name="question1">
            </div>
            <div class="form-group">
                <label for="question2">2. What cooking appliances is accessible to you?</label>
                <input type="text" class="form-control" id="question2" name="question2"
                    placeholder="e.g. Stove, Oven, Air Fryer .etc">
            </div>
            <div class="form-group">
                <label for="question3">3. How much time do you have for cooking (in mins)?</label>
                <input type="text" class="form-control" id="question3" name="question3">
            </div>
            <button type="submit" class="btn btn-primary">Generate Recipe</button>
        </form>
    </div>
</body>

</html>
