@extends('layouts.app')

@section('title', "Genre - $genre")

@section('content')

    <div class="d-flex justify-content-around flex-wrap">
        @foreach ($mangas as $manga)
            @include('_partials.manga_block')
        @endforeach
    </div>
    <div class="d-flex justify-content-center mb-4">
        {{ $mangas->links() }}
    </div>

@endsection