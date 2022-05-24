@extends('layouts.app')

@section('title', 'Manga++ - Genres')

@section('content')


    <div class="row">
        @foreach ($genres as $key => $genre)
            @if (in_array($key, [0, 11, 22]))
                <div class="col-md-4">
            @endif

                    <div class="text-center">
                        <h1 class="text-uppercase">
                            <a href="{{ route('app.genre', $key) }}" class="text-decoration-none grey-hover badge rounded-pill bg-secondary">
                                {{$genre}}
                            </a>
                        </h1>
                    </div>

            @if (in_array($key, [10, 21, 32]))
                </div>
            @endif
        @endforeach
    </div>

@endsection