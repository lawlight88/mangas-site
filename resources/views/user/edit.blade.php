@extends('layouts.app')

@section('title', "Edit User - $user->name")

@section('content')
    <div class="row bg-dark-1 p-4 mb-4">
        <div class="d-flex justify-content-center col-md-4">
            <img src="{{ asset($user->profile_image) }}" alt="profile image" class="img-fluid">
        </div>
        <div class="col-md-8">
            <form action="{{ route('user.edit', $user->id) }}" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row mb-3">
                    <div class="col-4">
                        <label for="name">Name:</label>
                        <input class="form-control mb-2" type="text" name="name" id="name" value="{{ $user->name }}">
                        <label for="password">Password:</label>
                        <input class="form-control mb-2" type="password" name="password" id="password">
                        <label for="profile_image">Profile Image:</label>
                        <input class="form-control" type="file" name="profile_image" id="profile_image">
                    </div>
                    <div class="col-md-3 offset-md-2">
                        @include('includes.validation-form')
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-4 text-center">
                        <button type="submit" class="btn w-50 btn-light">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection