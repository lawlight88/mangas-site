@extends('layouts.app')

@section('title', 'Mangas++ - Search')

@section('content')

    <div class="text-center mb-3">
        <h2 class="text-light">
            Results for: {{request()->get('search')}}
        </h2>
        @if (!$mangas->first())
            <h2 class="mt-5">Nothing was found...</h2>
        @endif
    </div>


    @include('includes.display_mangas')
    <div class="d-flex justify-content-center mb-4">
        {{ $mangas->withQueryString()->links() }}
    </div>

@endsection