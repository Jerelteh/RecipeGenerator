<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Recipe Generator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        .selectable {
            display: inline-block;
            padding: 10px;
            margin: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }

        .selected {
            background-color: #42459e;
            color: white;
        }
    </style>
</head>

<body>
    @include('layouts.sideNavBar')
    <div class="main-content">
        <h1>Generate Recipe</h1>

        <div class="content-container">
            <form id="recipeForm" action="{{ route('submit.input') }}" method="POST">
                @csrf
                @if (isset($recipeID))
                    <input type="hidden" class="" name="recipeID" value="{{ $recipeID }}">
                @endif
                @if ($isEditing)
                    <input type="hidden" name="isEditing" value="1">
                @endif
                <div class="form-group">
                    <label for="question1">1. What ingredients do you have on hand? (max 200 characters)</label>
                    <div id="question1">
                        <input type="text" class="form-control" id="question1" name="question1"
                            placeholder="e.g. rice, egg, fish etc." value="{{ $question1 }}" maxlength="200"><br>
                    </div>
                </div>
                <div class="form-group">
                    <label for="question2">2. Food Preparation Appliances:</label>
                    <div id="question2">
                        @foreach (['Blender', 'Food Processor', 'Juicer', 'Coffee Grinder', 'Mortar and Pestle'] as $appliance)
                            <div class="selectable {{ in_array($appliance, explode(', ', $question2)) ? 'selected' : '' }}"
                                data-value="{{ $appliance }}">
                                {{ $appliance }}
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="question2_input" name="question2" value="{{ $question2 }}"><br>
                </div>
                <div class="form-group">
                    <label for="question3">3. Kitchen Appliances for Cooking:</label>
                    <div id="question3">
                        @foreach (['Stove Top', 'Oven', 'Microwave', 'Grill', 'Air Fryer', 'Food Steamer', 'Pressure Cooker', 'Slow Cooker', 'Rice Cooker'] as $appliance)
                            <div class="selectable {{ in_array($appliance, explode(', ', $question3)) ? 'selected' : '' }}"
                                data-value="{{ $appliance }}">
                                {{ $appliance }}
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="question3_input" name="question3" value="{{ $question3 }}"><br>
                </div>
                <div class="form-group">
                    <label for="question4">4. How much time do you have for cooking (in mins)?</label>
                    <div class="col-xs-2">
                        <input type="number" class="form-control" id="question4" name="question4"
                            value="{{ $question4 }}" max="1440" min="5"
                            placeholder="max 1440mins(1d)"><br>
                    </div>

                </div>
                <div class="form-group">
                    <label for="question5">5. Level of Cooking Skill:</label>
                    <div id="question5">
                        @foreach (['Easy', 'Normal', 'Advanced'] as $level)
                            <div class="selectable {{ $level === $question5 ? 'selected' : '' }}"
                                data-value="{{ $level }}">
                                {{ $level }}
                            </div>
                        @endforeach
                    </div>
                    <input type="hidden" id="question5_input" name="question5" value="{{ $question5 }}"><br>
                </div>
                <div class="form-group">
                    <label for="question6">6. Enter Recipe Idea or Any Remarks (optional):</label>
                    <textarea class="form-control" id="question6" name="question6" rows="3"
                        placeholder="e.g. Want something low-calorie, prefer spicy foods...">{{ $question6 ?? '' }}</textarea><br>
                </div>
                <button type="submit" id="generateButton"
                    class="btn btn-primary d-flex justify-content-center align-items-center ">
                    <span id="spinner" class="spinner-border spinner-border-sm mr-2" style="display:none;"
                        role="status" aria-hidden="true"></span>
                    <span>Generate Recipe</span>
                </button>
                <button type="button" class="btn btn-secondary" id="cancelButton">Cancel</button>
            </form>
        </div>

    </div>

    <script>
        // for selectables 
        document.querySelectorAll('.selectable').forEach(item => {
            item.addEventListener('click', () => {
                if (item.parentElement.id === 'question5') {
                    document.querySelectorAll('#question5 .selectable').forEach(el => el.classList.remove(
                        'selected'));
                }
                item.classList.toggle('selected');
                updateInputs();
            });
        });

        function updateInputs() {
            const question2Selected = Array.from(document.querySelectorAll('#question2 .selected')).map(el => el.dataset
                .value).join(', ');
            const question3Selected = Array.from(document.querySelectorAll('#question3 .selected')).map(el => el.dataset
                .value).join(', ');
            const question5Selected = Array.from(document.querySelectorAll('#question5 .selected')).map(el => el.dataset
                .value).join(', ');

            document.getElementById('question2_input').value = question2Selected;
            document.getElementById('question3_input').value = question3Selected;
            document.getElementById('question5_input').value = question5Selected;
        }

        // Show spinner and disable button on form submit
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('recipeForm').addEventListener('submit', function() {
                var spinner = document.getElementById('spinner');
                spinner.style.display = 'inline-block'; // Show the spinner

                document.getElementById('generateButton').setAttribute('disabled', true);
            });
        });

        // Handle cancel button click
        document.getElementById('cancelButton').addEventListener('click', () => {
            history.back();
        });
    </script>
</body>

</html>
