@extends('layouts.management')

@section('title', $manga->name)

@section('content')

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
                        <small class="text-black-50">Uploaded At: {{$chapter->created_at->format('Y-m-d H:i')}}</small>
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