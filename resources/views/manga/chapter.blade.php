@extends('layouts.app')

@section('title', $manga->name)

@section('content')

    <div class="bg-dark-1 px-4 pt-4 pb-2 mb-3">
        @include('manga._partials.pagination')
        <img src="{{ asset($page->path) }}" alt="page-{{ $page->order }}" class="img-fluid mb-3"><br>
        @include('manga._partials.pagination')

        @if ($page->order == $manga->pages_count && ($chapter_order + 1) <= $manga->chapters_count)
            <div class="d-flex justify-content-center p-2">
                <a href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter_order+1]) }}" class="btn btn-light btn-lg">Go to Next Chapter</a>
            </div>
        @endif
    </div>

@endsection