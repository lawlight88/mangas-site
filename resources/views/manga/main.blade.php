@extends('layouts.app')

@section('title', $manga->name)

@section('content')

    <div class="row bg-dark-1 p-4 mb-4">
        <div class="col-md-3">
            <img src="{{ asset($cover) }}" alt="cover" class="img-fluid main-cover">
        </div>
        <div class="col-md-9">
            <h1>{{ $manga->name }}</h1>
            <h4>Author: {{ $manga->author }}</h4>
            <small>
                Genres:
                @foreach ($manga->genres as $genre)
                    <a href="#" class="badge bg-secondary rounded-pill text-decoration-none" >{{ $genre }}</a>
                @endforeach
            </small><br><br>
            <p>{{ $manga->desc }}</p>
            <div>
                {{ $manga->ongoing ? 'Ongoing' : 'Finished' }}
            </div>
            <small>Chapters: {{ $manga->chapters()->count() }}</small>
        </div>
    </div>

    <div class="bg-dark-1 p-4">
        @foreach ($manga->chapters as $chapter)
                <a href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter->order]) }}" class="d-block bg-light w-100 my-2 p-2 text-dark text-decoration-none">
                    <div class="row">
                        <div class="d-flex col-6 justify-content-start">
                            {{ $chapter->name }}
                        </div>
                        <div class="d-flex col-6 justify-content-end">
                            Uploaded at: {{ $chapter->created_at }}
                        </div>
                    </div>
                </a>
        @endforeach
    </div>

@endsection