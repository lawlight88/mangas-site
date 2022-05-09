@extends('layouts.management')

@section('title', 'Create Scan')

@section('content')

    <form action="{{ route('scan.create') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-5">

                @include('includes.validation-form')


                <label for="name">Name:</label><br>
                <input class="form-control" type="text" name="name" id="name" value="{{ old('name') }}"><br>
                <label for="desc">Description:</label><br>
                <textarea class="form-control" name="desc" id="desc" rows="3">{{ old('desc') }}</textarea><br>
                <label for="pages">Image:</label><br>
                <input class="form-control" type="file" name="image" id="image"><br>

                <div class="d-flex justify-content-center mb-4">
                    <button class="btn btn-light" type="submit">Submit</button>
                </div>

            </div>
        </div>

    </form>

@endsection