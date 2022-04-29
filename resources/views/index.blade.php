@extends('layouts.app')

@section('title', 'Mangas++')

@section('content')
    <div class="d-flex justify-content-between flex-wrap">
        @foreach ($covers_path as $cover)
            <div class="content-block mb-4">
                <a href="#">
                    <img class="idx-img" src="{{ asset("$cover") }}" width="175" height="200" alt="">
                </a>
            </div>
        @endforeach
    </div>
@endsection