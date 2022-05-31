@extends('layouts.app')

@section('title', "More Like $manga_base->name")

@section('content')

    @include('includes.display_mangas')
    <div class="d-flex justify-content-center mb-4">
        {{ $mangas->links() }}
    </div>

@endsection