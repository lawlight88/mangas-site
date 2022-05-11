@extends('layouts.management')

@section('title', 'Scan Requests')

@section('content')

    @if (empty($scan->requests->first()))
        @include('manga.management._partials.request_empty')
    @endif

    @foreach ($scan->requests as $key => $request)
        @if ($key != 0)
            <hr>
        @endif
        <div>
            @include('manga.management._partials.request_header')
            <div class="d-flex justify-content-between">
                @include('manga.management._partials.request_status')
                <div>
                    <form action="{{ route('request.cancel', $request->id) }}" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="text-light btn fa-lg d-inline-block"><i class="fa-solid fa-x"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection