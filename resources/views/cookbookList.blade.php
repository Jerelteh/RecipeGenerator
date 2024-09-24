<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cookbook List</title>
    <!-- Add Bootstrap CSS for modal functionality -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <style>
        a .btn-primary {
            background-color: #eba800;
            border-color: #eba800;
            transition: background-color 0.5s ease;
        }

        a .btn-primary:hover {
            background-color: #fdd600;
            border-color: #fdd600;
        }
    </style>
</head>

<body>
    @extends('layouts.sideNavBar')

    <div class="main-content">
        <h1>My Cookbooks</h1>
        @include('layouts.sessionMessage')

        <div class="content-container">
            <div class="content-header">
                <h2>Created Cookbooks</h2>
            </div>

            @if ($cookbooks->isEmpty())
                <p>No cookbooks created.</p>
            @else
                <ul style="list-style-type: none">
                    @foreach ($cookbooks as $cookbook)
                        <div>
                            <li>
                                <a href="{{ route('cookbooks.view', $cookbook->id) }}"
                                    style="text-decoration: none; color:black">
                                    <div class="card my-3">
                                        <div class="card-body">
                                            <section class="d-flex justify-content-between align-items-center">
                                                <div>
                                                    {{ $cookbook->title }}
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <!-- Delete Cookbook Form -->
                                                    <form action="{{ route('cookbooks.delete', $cookbook->id) }}"
                                                        method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger mr-3 d-flex justify-content-center align-items-center">
                                                            <span class="material-symbols-outlined">delete</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </section>
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </div>
                    @endforeach
                </ul>
            @endif

            {{-- Modal create cookbook trigger --}}
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#ModalCreate">
                Create Cookbook
            </button>
        </div>
    </div>

    {{-- Create Cookbook Button Modal --}}
    <div class="modal fade" id="ModalCreate" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">Create new Cookbook</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cookbooks.save') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Cookbook Title</label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
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
