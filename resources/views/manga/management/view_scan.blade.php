@extends('layouts.management')

@section('title', 'Scan View')

@section('content')

    @if (Auth::id() == $scan->leader)
        @include('manga.management._partials.scan_form')
    @endif

@endsection