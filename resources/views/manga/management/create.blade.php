@extends('layouts.app')

@section('title', 'Manga Upload')

@section('content')


    <form action="{{ route('manga.create') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-5">

                @include('includes.validation-form')


                <label for="name">Name:</label><br>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}"><br>
                <label for="desc">Description:</label><br>
                <textarea class="form-control" name="desc" id="desc" rows="3">{{ old('desc') }}</textarea><br>
                <label for="author">Author:</label><br>
                <input class="form-control" type="text" name="author" id="author" value="{{ old('author') }}"><br>
                <label for="pages">Cover:</label><br>
                <input class="form-control" type="file" name="cover" id="cover"><br>

                Genres:
                <div class="row">
                    @foreach ($genres as $key => $genre)
                        @if ($key == 0 || $key == 11 || $key == 22)
                            <div class="col-4">
                        @endif

                            <div class="form-check">
                                <input type="checkbox" name="genres[{{ $key }}]" value="{{ $key }}" id="{{ $genre }}"
                                    {{ old("genres.$key") ? 'checked="checked"' : null  }}
                                >
                                <label for="{{ $genre }}">{{ Str::ucfirst($genre) }}</label>
                            </div>

                        @if ($key == 10 || $key == 21 || $key == 32)
                            </div>
                        @endif
                        
                    @endforeach
                </div>

                <div class="d-flex justify-content-center my-3 form-check">
                    <input class="form-check-input" type="checkbox" name="ongoing" id="ongoing"
                        {{ old('ongoing') ? 'checked="checked"' : null }}
                    >
                    <label for="ongoing">Ongoing</label><br>
                </div>

                <div class="d-flex justify-content-center mb-4">
                    <button class="btn btn-light" type="submit">Submit</button>
                </div>

            </div>
        </div>

    </form>
@endsection