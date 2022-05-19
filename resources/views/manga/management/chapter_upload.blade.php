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
                        <img src="{{ asset($path) }}" alt="page {{$order}}" class="img-fluid d-block mx-auto">
                    </a>
                    <div class="row justify-content-center my-1">
                        <div class="col-5">
                            {{-- <input type="number" name="order" min="1" max="{{count($paths)}}" placeholder="{{$order}}" class="form-control form-control-sm"> --}}
                            <div class="input-group mt-2">
                                <input type="number" name="orders[{{$order}}]" min="1" max="{{count($paths)}}" placeholder="{{$order}}" value="{{ old("orders.$order") ?? $order }}" class="form-control form-control-sm">
                                <a href="{{ route('page.remove', ['manga' => $manga, 'order' => $order]) }}" class="btn btn-small btn-danger"><i class="fa-solid fa-x fa-sm text-light"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-end mt-4">
            <a href="{{ route('chapter.upload.cancel', $manga) }}" class="btn btn-danger text-light">Cancel</a>
            <button class="btn btn-primary text-light" type="submit">Edit Order</button>
            <button class="btn btn-success text-light" {{ count($paths) <= 2 ? 'disabled' : null }} type="submit" formaction="#">Upload</button>
        </div>
    </form>
    <form action="{{ route('page.add', $manga) }}" method="post" enctype="multipart/form-data">
        <div class="row mt-2 justify-content-end">
            @csrf
            <div class="col-md-4">
                <div class="input-group">
                    <input type="file" name="pages[]" class="form-control" multiple>
                    <button class="btn btn-info text-light" type="submit">Add</button>
                </div>
            </div>
        </div>
    </form>

@endsection