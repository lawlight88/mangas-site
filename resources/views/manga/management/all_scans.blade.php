@extends('layouts.management')

@section('title', 'Manga Management')

@section('content')

    <div class="d-flex justify-content-around flex-wrap">
        @foreach ($scans as $scan)
        <div class="bg-dark-1 mb-4 scan-block">
            <a href="{{ route('scan.view', $scan->id) }}">
                <img class="img-fluid mx-auto d-block" src="{{ asset($scan->image) }}">
            </a>
            <div class="py-3">
                <div>
                    {{$scan->name}}
                </div>
                <div>
                    <small>Created At: {{$scan->created_at->format('Y-m-d')}}</small>
                </div>
                {{-- <div>
                    <small>In charge of:</small>
                </div> --}}
            </div>
        </div>
        @endforeach
    </div>

@endsection