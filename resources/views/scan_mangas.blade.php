@extends('layouts.app')

@section('title', "$scan->name's Mangas")

@section('content')

    <div class="text-center text-light mb-3">
        <h4>
            {{ $scan->name }}'s Mangas
        </h4>
    </div>

    <div class="d-flex justify-content-around flex-wrap">
        @foreach ($scan->mangas as $manga)
            @include('_partials.manga_block')
        @endforeach
    </div>
    <div class="d-flex justify-content-center mb-4">
        {{ $scan->mangas->links() }}
    </div>

@endsection