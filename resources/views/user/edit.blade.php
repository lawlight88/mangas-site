@extends('layouts.app')

@section('title', "Edit User - $user->name")

@section('content')
    <div class="row bg-dark-1 p-4 mb-4">
        <div class="d-flex justify-content-center col-md-4">
            <img src="{{ asset($user->profile_image) }}" alt="profile image" class="img-fluid">
        </div>
        <div class="col-md-8">
            <form action="" method="post" enctype="multipart/form-data">
                @method('put')
                @csrf
                <div class="row px-4 mb-3">
                    <div class="col-3">
                        <label for="name">Name:</label>
                        <input class="form-control mb-2" type="text" name="name" id="name" value="{{ $user->name }}">
                        <label for="profile_image">Profile Image:</label>
                        <input class="form-control" type="file" name="profile_image" id="profile_image">
                    </div>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="favorites" value="false" id="favorites"
                        {{ old("favorites") ? 'checked="checked"' : null  }}
                    >
                    <label for="favorites">Don't show my favorites on profile</label>
                </div>
                <div class="form-check">
                    <input type="checkbox" name="comments" value="false" id="comments"
                        {{ old("comments") ? 'checked="checked"' : null  }}
                    >
                    <label for="comments">Don't show my comments on profile</label>
                </div>
                <div class="row mt-3">
                    <div class="col-3 text-center">
                        <button type="submit" class="btn btn-light">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection