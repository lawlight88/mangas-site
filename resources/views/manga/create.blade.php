@extends('layouts.app')

@section('title', 'Manga Upload')

@section('content')
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-5">
                <label for="name">Name:</label><br>
                <input class="form-control" type="text" name="name" id="name"><br>
                <label for="desc">Description:</label><br>
                <input class="form-control" type="text" name="desc" id="desc"><br>
                <label for="author">Author:</label><br>
                <input class="form-control" type="text" name="author" id="author"><br>
                <label for="pages">Chapter 1 Pages:</label><br>
                <input class="form-control" type="file" name="pages" id="pages" multiple><br>

                Genres:
                <div class="row">
                    @foreach ($genres as $key => $genre)
                        @if ($key == 0 || $key == 11 || $key == 22)
                            <div class="col-4">
                        @endif

                            <div class="form-check">
                                <input type="checkbox" name="genres[]" value="{{ $genre }}" id="{{ $genre }}">
                                <label for="{{ $genre }}">{{ Str::ucfirst($genre) }}</label>
                            </div>

                        @if ($key == 10 || $key == 21 || $key == 32)
                            </div>
                        @endif
                        
                    @endforeach
                </div>

                <div class="d-flex justify-content-center my-3">

                    <input class="form-check-input" type="radio" name="ongoing" id="ongoing">
                    <label for="ongoing">Ongoing</label><br>
                </div>



            </div>
        </div>

    </form>
@endsection