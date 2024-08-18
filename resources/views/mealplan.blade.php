<!-- resources/views/mealplan.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Plan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .meal-plan-container {
            background-color: #F8F5F2;
            color: #333;
            padding: 20px;
            border-radius: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1)
        }

        .meal-plan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-family: 'Poppins', sans-serif;
        }

        .meal-plan-days {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .meal-plan-day {
            background-color: #fefcef;
            border-radius: 5px;
            padding: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .meal-plan-week-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }

        .btn-outline-light {
            border-color: #FFB085;
            /* Matching the theme */
            color: #FF6F00;
            /* Darker orange for text */
        }

        .btn-outline-light:hover {
            background-color: #ffd600;
            color: #fff;
        }

        .btn-dark {
            background-color: #ffd600;
            /* Darker orange */
            border-color: #ffd600;
            color: white;
        }

        .btn-dark:hover {
            background-color: #ffec8f;
            border-color: #ffec8f;
            color: #fff;
        }
    </style>
</head>

<body>
    @include('layouts.sideNavBar')
    <div class="main-content">
        <div class="meal-plan-container">
            <div class="meal-plan-header">
                <h1>Meal Plan</h1>
            </div>

            <div class="meal-plan-days">
                @foreach ($days as $day => $date)
                    <div class="meal-plan-day">
                        <div>
                            <strong>{{ $day }}</strong> {{ $date }}
                        </div>
                        <button class="btn btn-outline-light">+ Plan</button>
                    </div>
                @endforeach
            </div>

            {{-- prev/next week --}}
            <div class="meal-plan-week-nav">
                <a href="{{ route('mealplan', ['weekOffset' => $weekOffset - 1]) }}" class="btn btn-dark"
                    style="border-radius: 12px">&lt;</a>
                <span>Week of {{ $weekStart }} - {{ $weekEnd }}</span>
                <a href="{{ route('mealplan', ['weekOffset' => $weekOffset + 1]) }}" class="btn btn-dark"
                    style="border-radius: 12px">&gt;</a>
            </div>
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
