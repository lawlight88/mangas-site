@extends('layouts.management')

@section('title', 'Scan View')

@section('content')

    @can(['update', 'delete'], $scan)
        <div class="d-flex justify-content-center mb-2">
            <img src="{{ asset($scan->image) }}" alt="scan image" width="425" class="img-fluid">
        </div>
        @include('manga.management._partials.scan_form')
        <div class="d-flex justify-content-center">
            <form action="{{ route('scan.delete', $scan) }}" method="post">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-sm btn-danger">Delete Scan</button>
            </form>
        </div>
    @else
        @include('includes.view_scan')
    @endcan

@endsection