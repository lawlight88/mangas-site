@extends('layouts.management')

@section('title', 'Scan View')

@section('content')

    @if (!(Auth::id() == $scan->leader || Auth::user()->role == 4)) {{---------------------------}}
        <div class="row bg-dark-1 p-4 mb-4">
            <div class="col-md-4">
                <img src="{{ asset($scan->image) }}" alt="scan image" class="img-fluid">
            </div>
            <div class="col-md-8">
                <div>Name: {{ $scan->name }}</div>
                <div>Created At: {{ $scan->created_at->format('Y-m-d H:i') }}</div>
                <div>Leader: <a href="{{ route('user.profile', $scan->leader->id) }}">{{ $scan->leader->name }}</a></div>
            </div>
        </div>
        {{-- members... --}}
    @else
        @include('manga.management._partials.scan_form')
    @endif

@endsection