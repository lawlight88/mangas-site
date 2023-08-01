@extends('layouts.app')

@section('title', $manga->name)

@section('content')

    <div class="bg-dark-1 px-4 pt-4 pb-2 mb-3">
        @include('manga._partials.pagination')

        <div class="d-flex justify-content-center">
            <a href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter_order, 'page_order' => $page->order + 1]) }}">
                <img src="{{ asset($page->path) }}" alt="page-{{ $page->order }}" class="img-fluid mb-3"><br>
            </a>
        </div>

        @include('manga._partials.pagination')


        @if ($page->order == $manga->pages_count)
            <div class="d-flex justify-content-center p-2">
                @if ($chapter_order + 1 <= $manga->chapters_count)
                    <a href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter_order+1]) }}" class="btn btn-light btn-lg">Go to Next Chapter</a>
                @else
                    <a href="{{ route('app.manga.main', $manga->id) }}" class="btn btn-light btn-lg">Last Uploaded Chapter</a>
                @endif
            </div>
        @endif
    </div>

    <div class="bg-dark-1 p-4 mb-5">
        @auth
            @include('manga._partials.comment_form')
        @else
            <textarea class="form-control" name="body" placeholder="Log in to comment..." rows="3" disabled></textarea>
        @endauth

        @if (empty($comments->first()))
            <hr>
            <div class="text-center h4 mt-4">
                There are not any comments
            </div>
        @else
            @foreach ($comments as $comment)
                <hr>
                @include('_partials.comment')
            @endforeach
        @endif

    </div>

@endsection