@extends('layouts.management')

@section('title', 'Upload New Chapter')

@section('content')

    @include('includes.validation-form')

    <div>Pages:</div>
    <form action="{{ route('page.order', $manga) }}" method="post">
        @csrf
        @method('put')
        <div>
            @foreach ($paths as $order => $path)
                <div class="img-block d-inline-block bg-dark-1 mb-1">
                    <a href="{{ asset($path) }}" target="_blank">
                        <img src="{{ asset($path) }}" alt="page {{$order}}" class="img-fluid">
                    </a>
                    <div class="row justify-content-center my-1">
                        <div class="col-3">
                            {{-- <input type="number" name="order" min="1" max="{{count($paths)}}" placeholder="{{$order}}" class="form-control form-control-sm"> --}}
                            <input type="number" name="orders[{{$order}}]" min="1" max="{{count($paths)}}" placeholder="{{$order}}" value="{{ old("orders.$order") ?? $order }}" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-end mt-4">
            <button class="btn btn-primary text-light" type="submit">Edit Order</button>
            <button class="btn btn-success text-light" type="submit" formaction="#">Upload</button>
        </div>
    </form>

@endsection