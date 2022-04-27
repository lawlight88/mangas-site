@extends('layouts.app')

@section('title', 'Mangas++')

@section('content')
    <div class="d-flex justify-content-between flex-wrap">
        @foreach ($covers_pop as $cover)
            <div class="content-block mb-4">
                <a href="#">
                    <img src="data:image/png;base64,{{ $cover }}" alt="">
                </a>
            </div>
        @endforeach
    </div>
@endsection