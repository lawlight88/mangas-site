@extends('layouts.app')

@section('title', $manga->name)

@section('content')

    <div class="bg-dark-1 px-4 pt-4 pb-2 mb-3">
        @include('manga._partials.pagination')
        <img src="{{ asset($page->path) }}" alt="page-{{ $page->order }}" class="img-fluid mb-3"><br>
        @include('manga._partials.pagination')
    </div>

@endsection