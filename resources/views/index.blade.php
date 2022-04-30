@extends('layouts.app')

@section('title', 'Mangas++')

@section('content')
    <div class="d-flex justify-content-between flex-wrap">
        @foreach ($pop_covers_path as $cover)
            <div class="content-block mb-4">
                <a href="#">
                    <img class="img-fluid" src="{{ asset("$cover") }}">
                </a>
            </div>
        @endforeach
    </div>
    <hr>
    <div class="d-flex justify-content-between flex-wrap">
        @foreach ($covers_path as $cover)
            <div class="content-block mb-4">
                <a href="#">
                    <img class="img-fluid" src="{{ asset("$cover") }}">
                </a>
            </div>
        @endforeach
    </div>
    
@endsection