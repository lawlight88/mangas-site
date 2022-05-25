@extends('layouts.management')

@section('title', 'History')

@section('content')

    @if (empty($requests->first()))
        @include('manga.management._partials.request_empty')
    @endif

    @foreach ($requests as $key => $request)
        @if ($key != 0)
            <hr>
        @endif
        <div>
            <div class="row">
                @include('manga.management._partials.request_header')
                <div class="col-6 d-flex justify-content-between">
                    @include('manga.management._partials.request_status')
                </div>
                @cannot('adminRequests', \App\Models\Request::class)
                    <div class="col-6 d-flex justify-content-end">
                        <small class="text-secondary">Answered At: {{ $request->updated_at->diffForHumans() }}</small>
                    </div>
                @endcannot
            </div>
        </div>
    @endforeach

@endsection