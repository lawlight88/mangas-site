@extends('layouts.management')

@section('title', 'Scan View')

@section('content')

    @if (!(Auth::id() == $scan->leader || Auth::user()->role == 4)) {{---------------------------}}
        @include('includes.view_scan')
    @else
        @include('manga.management._partials.scan_form')
    @endif

@endsection