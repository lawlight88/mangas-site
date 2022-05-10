@extends('layouts.management')

@section('title', 'Scan View')

@section('content')

    @can('update', $scan)
        @include('manga.management._partials.scan_form')
    @else
        @include('includes.view_scan')
    @endcan

@endsection