@extends('layouts.app')

@section('title', $manga->name)

@section('content')

    <div class="bg-dark-1 px-4 pt-4 pb-2 mb-3">
        @include('manga._partials.pagination')
        <img src="{{ asset($page->path) }}" alt="page-{{ $page->order }}" class="img-fluid mb-3"><br>
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

    <div class="bg-dark-1 p-4 mb-4">
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
                <div class="p-2">
                    <div class="d-flex justify-content-between">
                        <a class="text-decoration-none text-light" href="#">{{$comment->user->name}}</a>
                        <span>
                            @if ($comment->updated_at > $comment->created_at)
                                <small>(edited)</small>
                            @endif
                            {{$comment->created_at->format('Y-m-d H:i')}}
                        </span>
                    </div>
                    <div class="p-2" id="{{ $comment->id }}">
                        {{$comment->body}}
                    </div>
                    
                    @if (Auth::id() == $comment->id_user)
                        @if ($id_comment_edit == $comment->id)
                            @include('manga._partials.comment_form')                               
                        @endif
                        @if (is_null($id_comment_edit))
                            <div class="d-flex justify-content-end">
                                <a href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter_order, 'page_order' => $page->order, 'id_comment_edit' => $comment->id]) . "#$comment->id" }}" class="text-light"><i class="fas fa-edit"></i></a>
                            </div>
                        @endif
                    @endif
                </div>
            @endforeach
        @endif

    </div>

@endsection