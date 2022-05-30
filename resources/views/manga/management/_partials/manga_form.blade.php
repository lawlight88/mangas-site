<form action="{{ Request::routeIs('manga.edit.info') ? route('manga.edit.info', $manga) : route('manga.create') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if (Request::routeIs('manga.edit.info'))
        @method('put')
    @endif
    <div class="row justify-content-center">
        <div class="col-md-{{ Request::routeIs('manga.edit.info') ? '6' : '5' }}">

            @include('includes.validation-form')

            <label for="name">Name:</label><br>
            <input class="form-control" {{ Request::routeIs('manga.edit.info') ? 'disabled' : null }} type="text" name="name" id="name" value="{{ $manga->name ?? old('name') }}"><br>
            <label for="desc">Description:</label><br>
            <textarea class="form-control" name="desc" id="desc" rows="3">{{ $manga->desc ?? old('desc') }}</textarea><br>
            <label for="author">Author:</label><br>
            <input class="form-control" type="text" name="author" id="author" value="{{ $manga->author ?? old('author') }}"><br>
            <label for="pages">Cover:</label><br>
            <input class="form-control" type="file" name="cover" id="cover"><br>

            Genres:
            <div class="row">
                @foreach ($genres as $genre_key => $genre)
                    @if (in_array($genre_key, [0, 11, 22]))
                        <div class="col-4">
                    @endif

                        <div class="form-check">
                            <input type="checkbox" name="genres[]" value="{{ $genre_key }}" id="{{ $genre }}"
                                {{ old("genres.$genre_key") 
                                || isset($manga) 
                                && in_array($genre_key, $manga_genres)
                                ? 'checked="checked"' : null  }}
                            >
                            <label for="{{ $genre }}">{{ Str::ucfirst($genre) }}</label>
                        </div>

                    @if (in_array($genre_key, [10, 21, 32]))
                        </div>
                    @endif
                    
                @endforeach
            </div>

            <div class="d-flex justify-content-center my-3 form-check">
                <input class="form-check-input" type="checkbox" name="ongoing" id="ongoing"
                    {{ old('ongoing')
                    || isset($manga)
                    && $manga->ongoing
                    ? 'checked="checked"' : null }}
                >
                <label for="ongoing">Ongoing</label><br>
            </div>

            <div class="d-flex justify-content-center mb-4">
                <button class="btn btn-light" type="submit">Submit</button>
            </div>

        </div>
    </div>

</form>