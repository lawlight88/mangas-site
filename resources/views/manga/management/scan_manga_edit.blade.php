@extends('layouts.management')

@section('title', $manga->name)

@section('content')

    @include('includes.validation-form')

    <div class="d-flex justify-content-center mb-3">
        <div class="card bg-light-1">
            <div class="card-body">
                <form action="{{ route('chapter.upload', $manga) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="pages[]" class="form-control" multiple>
                    <div class="text-center mt-3">
                        <button type="submit" href="{{ route('chapter.upload', $manga) }}" class="btn btn-info text-light">Upload New Chapter</button>
                        <br>
                        <small class="text-secondary">Only jpg, png and pdf format are supported.</small>
                    </div>
                    @if (Storage::disk('temp')->allFiles($manga->id))
                        <hr class="text-dark">
                        <div class="text-center">
                            <a href="{{ route('chapter.upload.continue', $manga) }}" class="btn btn-secondary">Continue</a>
                        </div>
                    @endif
                </form>
            </div>
        </div>
    </div>

    @if (empty($manga->chapters->first()))
        <div class="text-center my-5">
            <h5>
                There are not any chapter.
            </h5>
        </div>
    @else
        <div class="list-group">
            @foreach ($manga->chapters as $chapter)
                <div class="list-group-item list-group-item-action flex-column align-items-start bg-light-1">
                    <div class="d-flex w-100 justify-content-between">
                        <a href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter->order]) }}" class="h5 mb-1 text-decoration-none text-dark">
                            {{$chapter->name}}
                        </a>
                        <small class="text-black-50">Uploaded At: {{$chapter->created_at->diffForHumans()}}</small>
                    </div>
                    <div class="row">
                        <div class="col-9">Today Views:</div>
                        <div class="col-3 d-flex justify-content-end">
                            <form action="{{ route('chapter.delete', $chapter) }}" method="post" class="d-inline">
                                @method('delete')
                                @csrf
                                <a href="{{ route('chapter.edit', $chapter) }}" class="text-light btn fa d-inline"><i class="fas fa-edit text-info"></i></a>
                                <button type="submit" class="text-light btn fa d-inline"><i class="fa-solid fa-x text-danger"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


    <div class="d-flex justify-content-center mb-4">
        {{ $manga->chapters->links() }}
    </div>

@endsection