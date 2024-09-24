<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        .stats-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        .stat {
            text-align: center;
            padding: 20px;
            background-color: #42459E;
            color: #fff;
            border-radius: 5px;
            margin-bottom: 20px;
            width: calc(50% - 10px);
        }

        .stat i {
            font-size: 24px;
            margin-bottom: 10px;
        }

        .stat p {
            font-weight: bold;
            font-size: 18px;
        }

        .stat span {
            font-size: 14px;
            color: #c7c7c7;
        }
    </style>
</head>

<body>
    @include('layouts.sideNavBar')

    <div class="main-content">
        <h1>My Profile</h1>
        <div class="content-container">

            {{-- <x-app-layout>
            {{-- <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Dashboard') }}
                </h2>
            </x-slot> --}}

            {{-- MAIN CONTENT
            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 bg-white border-b border-gray-200">
                            You're logged in!
                            <a href="{{ route('homepage') }}" class="text-blue-500">Go to Homepage</a>
                        </div>
                    </div>
                </div>
            </div> 
            </x-app-layout> --}}

            <div>
                {{-- User Account Details --}}
                <h2>
                    Account Details
                </h2>
                <p><strong>Name:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Email:</strong> {{ Auth::user()->email }}</p>


            </div>
            {{-- <div class="container mt-5">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="cord-body">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">

                        </div>
                    </div>
                </div>
            </div> --}}


            <div class="stats-container">
                <div class="stat">
                    <p>{{ $totalRecipes }}</p>
                    <span>Total Recipes</span>
                </div>
                <div class="stat">
                    <p>{{ $totalCookbooks }}</p>
                    <span>Total Cookbooks</span>
                </div>

                <button class="stat confetti-btn" style="background-color: #FDD600; width: 100%; border: none;" onclick>
                    {{-- Display How Long the User Has Been Registered --}}
                    @php
                        use Carbon\Carbon;
                        $createdDate = Auth::user()->created_at;
                        $daysAsUser = Carbon::now()->diffInDays($createdDate);
                    @endphp
                    <p>{{ $daysAsUser }}</p>
                    <span style="color: #7b7b7b">Days as a Lemon user</span>
                </button>
            </div>


            {{-- MAIN CONTENT --}}
            <div class="py-12">
                <div>
                    <em>You're logged in! <a href="{{ route('homepage') }}" class="text-blue-500">Go to
                            Homepage</a></em>
                </div>
            </div>
            {{-- Logout Button --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-danger" style="margin-top: 10px;">
                    Logout
                </button>
            </form>
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
    {{-- confetti effect --}}
    <script src="https://cdn.jsdelivr.net/npm/@tsparticles/confetti@3.0.3/tsparticles.confetti.bundle.min.js"></script>
    <script>
        const confettiBtn = document.querySelector(".confetti-btn");

        confettiBtn.addEventListener("click", () => {
            confetti({
                particleCount: 600,
                spread: 150,

                startVelocity: 70,
                ticks: 50,
                gravity: 1,
                origin: {
                    x: 1,
                    y: 0.8
                },
            });
            confetti({
                particleCount: 600,
                spread: 150,

                startVelocity: 70,
                ticks: 50,
                gravity: 1,
                origin: {
                    x: 0,
                    y: 0.8
                },
            });
        })
    </script>
</body>

</html>
