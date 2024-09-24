<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('css/nonLoggedIn.css') }}">
    <!-- For Register button -->
    <link rel="stylesheet" href="{{ asset('css/generateRecipeBtn.css') }}">
</head>

<body>
    <div class="main-content">
        <h1>Register an Account</h1>
        <div class="content-container">
            <x-auth-card>
                <!-- Validation Errors -->
                <x-auth-validation-errors class="mb-4" :errors="$errors" />

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <!-- Name -->
                    <div>
                        <x-label for="name" :value="__('Name')" />
                        <x-input id="name" class="block mt-1 w-full rounded-edge" type="text" name="name"
                            :value="old('name')" required autofocus />
                    </div>
                    <!-- Email Address -->
                    <div class="">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" class="block mt-1 w-full rounded-edge" type="email" name="email"
                            :value="old('email')" required />
                    </div>
                    <!-- Password -->
                    <div class="">
                        <x-label for="password" :value="__('Password')" />
                        <x-input id="password" class="block mt-1 w-full rounded-edge" type="password" name="password"
                            required autocomplete="new-password" />
                    </div>
                    <!-- Confirm Password -->
                    <div class="">
                        <x-label for="password_confirmation" :value="__('Confirm Password')" />

                        <x-input id="password_confirmation" class="block mt-1 w-full rounded-edge" type="password"
                            name="password_confirmation" required />
                    </div>

                    <div class="flex items-center justify-end my-4">
                        <!-- Register -->
                        <div class="text-center">
                            <x-button class="generate-recipe-btn" style="--clr:#FFD600">
                                {{ __('Register') }}
                            </x-button>
                        </div>
                        <!-- ALready Registered -->
                        <div class="text-center">
                            <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                                {{ __('Already registered?') }}
                            </a>
                        </div>
                    </div>
                </form>
            </x-auth-card>
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
