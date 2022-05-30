@extends('layouts.app')

@section('title', 'Mangas++')

@section('content')
    <div class="row justify-content-center">
        <h2 class="text-light col-4 text-center">
            Popular Now
            <hr>
        </h2>
    </div>
    <div class="d-flex justify-content-around flex-wrap">
        @foreach ($mangas_pop as $manga)
            @include('_partials.manga_block')
        @endforeach
    </div>
    <div class="row justify-content-center">
        <h2 class="text-light col-4 text-center">
            Recently Uploaded
            <hr>
        </h2>
    </div>
    <div class="d-flex justify-content-around flex-wrap">
        @foreach ($mangas_new as $manga)
            @include('_partials.manga_block')
        @endforeach
    </div>
    <div class="d-flex justify-content-center mb-4">
        {{ $mangas_new->links() }}
    </div>
@endsection