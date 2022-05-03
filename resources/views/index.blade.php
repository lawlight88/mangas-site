@extends('layouts.app')

@section('title', 'Mangas++')

@section('content')
    <div class="d-flex justify-content-around flex-wrap">
        @foreach ($mangas_pop as $id => $cover)
            <div class="manga-block bg-dark-1 mb-4">
                <a href="{{ route('app.manga.main', $id) }}">
                    <img class="img-fluid" src="{{ asset("$cover") }}">
                </a>
            </div>
        @endforeach
    </div>
    <hr>
    <div class="d-flex justify-content-around flex-wrap">
        @foreach ($mangas_new as $id => $cover)
            <div class="manga-block bg-dark-1 mb-4">
                <a href="{{ route('app.manga.main', $id) }}">
                    <img class="img-fluid" src="{{ asset("$cover") }}">
                </a>
            </div>
        @endforeach
    </div>

    {{-- <div class="py-3">
        {{ $users->appends([
            'search' => request()->get('search', '')
        ])->links('pagination::bootstrap-5') }}
    </div> --}}
    
@endsection