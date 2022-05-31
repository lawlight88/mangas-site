@extends('layouts.app')

@section('title', $manga->name)

@section('content')

    <div class="row bg-dark-1 p-4 mb-4">
        <div class="col-md-3">
            <img src="{{ asset($manga->cover) }}" alt="cover" class="img-fluid main-cover">
        </div>
        <div class="col-md-9">
            <h1>{{ $manga->name }}</h1>
            <h4>Author: {{ $manga->author }}</h4>
            <div class="mb-1">
                <small>
                    Genres: <br>
                    @foreach ($manga->genres as $genre_key => $genre)
                        <a href="{{ route('app.genre', $genre_key) }}" class="badge black-hover bg-secondary rounded-pill text-decoration-none" >{{ $genre }}</a>
                    @endforeach
                </small>
            </div>
            <div>
                <small>Description:</small>
            </div>
            <div class="px-3 mb-1">{{ $manga->desc }}</div>
            <div class="text-success-1">
                {{ $manga->ongoing ? 'Ongoing' : 'Finished' }}
            </div>
            <small>Chapters: {{ $manga->chapters->count() }}</small><br>
            <div class="mb-3">
                <small>Scanlator:
                    @if (isset($manga->scanlator))
                        <a href="{{ route('app.scan.view', $manga->scanlator) }}" class="text-secondary">{{ $manga->scanlator->name }}</a>
                    @else
                        <span class="text-warning">None</span>
                    @endif
                </small>
            </div>
            <div class="d-flex justify-content-between">
                <div>
                    @can('request', [\App\Models\Request::class, $manga])
                        <form action="{{ route('request.create', $manga->id) }}" method="post" class="d-inline">
                            @csrf
                            <button class="d-inline btn {{ is_null($requested) ? 'btn-primary' : 'btn-secondary' }}" {{ is_null($requested) ? '' : 'disabled' }} type="submit">Request</button>
                        </form>
                    @endcan
                    @can('edit', $manga)
                        <a href="{{ route('manga.edit', $manga) }}" class="btn btn-primary text-light">Edit Chapters</a>
                    @endcan
                    @can('editInfo', $manga)
                        <a href="{{ route('manga.edit.info', $manga) }}" class="btn btn-primary text-light">Edit Info</a>
                    @endcan
                    @auth
                        <form action="{{ route('favorite.create', $manga) }}" method="post" class="mt-2 d-inline">
                            @csrf
        
                            @if (\App\Models\Favorite::isMangaOnFavorites(Auth::id(), $manga->id))
                                @method('delete')
                                <button class="btn btn-danger text-light d-inline" formaction="{{ route('favorite.remove', $manga) }}" type="submit">Remove from Favorites</button>
                            @else
                                <button class="btn btn-warning text-light d-inline" type="submit">Favorite</button>
                            @endif
                        </form>
                    @endauth
                </div>
                @can('delete', $manga)
                    <form action="{{ route('manga.delete', $manga) }}" method="post">
                        @csrf
                        @method('delete')
                        <button class="btn btn-danger text-light d-inline" type="submit">Delete</button>
                    </form>
                @endcan
            </div>
        </div>
    </div>

    <div class="bg-dark-1 p-4 mb-4">
        @if (!empty($manga->chapters->first()))
            <div class="d-flex justify-content-end">
                <a href="#{{$manga->chapters->last()->id}}" class="link-light">Last Chapter</a>
            </div>
            @foreach ($manga->chapters as $chapter)
                    <a id="{{ $chapter->id }}" href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter->order]) }}" class="d-block bg-light w-100 my-2 p-2 text-dark text-decoration-none">
                        <div class="row">
                            <div class="d-flex col-6 justify-content-start">
                                {{ $chapter->name }}
                            </div>
                            <div class="d-flex col-6 justify-content-end">
                                Uploaded: {{ $chapter->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </a>
            @endforeach
            <div class="d-flex justify-content-end">
                <a href="#{{$manga->chapters->first()->id}}" class="link-light">First Chapter</a>
            </div>
        @else
            <div class="mt-3 text-center">
                <h2>This manga does not have chapters</h2>
            </div>
        @endif
    </div>

    <div class="bg-dark-1 p-4 mb-4">
        <div class="row justify-content-center">
            <h2 class="text-light col-4 text-center">
                Like This
                <hr>
            </h2>
        </div>
        <div class="row justify-content-around flex-wrap">
            @foreach ($mangas_like_this as $manga_like_this)
                <div class="col-sm-6 col-md-4 col-lg-3">
                    @include('_partials.manga_block')
                </div>
            @endforeach
        </div>
        <div class="row justify-content-center">
            <h3 class="col-4 text-center">
                <a href="{{ route('app.like.this', $manga) }}" class="link-light text-decoration-none">
                    More
                </a>
            </h3>
        </div>
    </div>

@endsection