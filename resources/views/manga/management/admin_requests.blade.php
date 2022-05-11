@extends('layouts.management')

@section('title', 'All Requests')

@section('content')

    @if (empty($requests->first()))
        @include('manga.management._partials.request_empty')
    @endif

    @foreach ($requests as $key => $request)
        @if ($key != 0)
            <hr>
        @endif
        <div>
            @include('manga.management._partials.request_header')
            <div class="d-flex justify-content-between">
                @include('manga.management._partials.request_status')
                <div>
                    <form action="{{ route('request.accept', $request->id) }}" method="post" class="d-inline">
                        @method('put')
                        @csrf
                        <button class="text-light btn fa-lg d-inline-block"><i class="fas fa-check"></i></button>
                    </form>
                    <form action="{{ route('request.refuse', $request->id) }}" method="post" class="d-inline">
                        @method('put')
                        @csrf
                        <button type="submit" class="text-light btn fa-lg d-inline-block"><i class="fa-solid fa-x"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection