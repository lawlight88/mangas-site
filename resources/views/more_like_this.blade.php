@extends('layouts.app')

@section('title', "More Like $manga_base->name")

@section('content')

    <div class="text-center mb-3">
        <h2 class="text-light">
            More like {{$manga_base->name}}
        </h2>
    </div>

    @include('includes.display_mangas')
    <div class="d-flex justify-content-center mb-4">
        {{ $mangas->links() }}
    </div>

@endsection