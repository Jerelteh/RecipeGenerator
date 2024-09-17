<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Body Fat Calculator</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        <h1>Body Fat Percentage Calculator</h1>
        @include('layouts.sessionMessage')

        <div class="content-container">
            <div class="content-header">
                {{-- <h2>Please enter your body measurements</h2> --}}
            </div>

            <form action="{{ route('body.fat.calculate') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="sex">Sex</label>
                    <select id="sex" name="sex" class="form-control" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="height">Height (cm)</label>
                    <input type="number" id="height" name="height" class="form-control" min="1" required>
                </div>

                <div class="form-group">
                    <label for="neck">Neck Circumference (cm)</label>
                    <input type="number" id="neck" name="neck" class="form-control" min="1" required>
                </div>

                <div class="form-group">
                    <label for="abdominal">Abdominal Circumference (cm)</label>
                    <input type="number" id="abdominal" name="abdominal" class="form-control" min="1" required>
                </div>

                <button type="submit" class="btn btn-warning">Calculate Body Fat</button>
            </form>

            {{-- Display result if body fat is calculated --}}
            @if (isset($bodyFat))
                <div class="mt-5">
                    <h2>Your Body Fat Percentage</h2>
                    <div class="alert alert-info">
                        <strong>{{ $bodyFat }}%</strong>
                    </div>
                </div>
            @endif
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
