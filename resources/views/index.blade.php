@extends('layouts.app')

@section('title', 'Mangas++')

@section('content')
    <div class="d-flex justify-content-around flex-wrap">
        @foreach ($mangas_pop as $id => $cover)
            @include('_partials.manga_block')
        @endforeach
    </div>
    <hr>
    <div class="d-flex justify-content-around flex-wrap">
        @foreach ($mangas_new as $id => $cover)
            @include('_partials.manga_block')
        @endforeach
    </div>
@endsection