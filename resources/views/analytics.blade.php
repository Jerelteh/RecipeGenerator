<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        <div class="content-container">
            <h1>Recipe Generation Analytics</h1>
            <div class="container" style="padding-top: 20px">
                <!-- Month Selector -->
                <form action="{{ route('analytics') }}" method="GET" class="form-inline mb-4">
                    <label for="month" class="mr-2">Select Month:</label>
                    <input type="month" name="month" id="month" class="form-control"
                        value="{{ $currentMonth }}">
                    <button type="submit" class="btn btn-primary ml-2">View</button>
                </form>

                <!-- Total Recipes This Month -->
                <div class="alert alert-info">
                    <strong>Total Recipes Generated This Month:</strong> {{ $totalRecipesThisMonth }}
                </div>

                <!-- Chart.js Canvas -->
                <canvas id="recipeChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('recipeChart').getContext('2d');
        const recipeChart = new Chart(ctx, {
            type: 'line', // Change chart type to 'line'
            data: {
                labels: @json($dates),
                datasets: [{
                    label: 'Recipes Generated',
                    data: @json($counts),
                    fill: false, // Disable fill under the line
                    borderColor: 'rgba(95, 100, 250, 1)', // Line color
                    backgroundColor: 'rgba(95, 100, 250, 0.2)', // Point background color
                    pointBorderColor: 'rgba(95, 100, 250, 1)', // Point border color
                    pointBackgroundColor: 'rgba(255, 255, 255, 1)', // Point background color
                    pointRadius: 5, // Point size
                    lineTension: 0.1 // Smoothing of the line (0 for straight lines)
                }]
            },
            options: {
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Recipes Generated'
                        },
                        ticks: {
                            stepSize: 1, // Ensure discrete values
                        }
                    }
                }
            }
        });
    </script>
</body>

</html>
