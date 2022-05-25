@extends('layouts.app')

@section('title', 'My Favorites')

@section('content')

    <div class="d-flex justify-content-around flex-wrap">
        @foreach ($favorites as $favorite)
            @include('_partials.manga_block')
        @endforeach
    </div>
    <div class="d-flex justify-content-center mb-4">
        {{ $favorites->links() }}
    </div>

@endsection