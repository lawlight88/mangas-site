@include('includes.validation-form')

<form action="{{ isset($qty_temp_files) ? route('page.onUpload.order', $manga) : route('page.onEdit.order&name', $chapter) }}" method="post">
    <div class="row">
        <div class="col-md-4">
            <label for="chapter">Chapter Name:</label>
            <input type="text"
                name="name"
                value="{{ $chapter->name ?? null }}"
                placeholder="{{ Request::routeIs('chapter.edit') ? null : 'The name will only be saved on the upload' }}"
                class="form-control"
                id="chapter"
                maxlength="30"
            >
        </div>
    </div>
    <div class="my-2">Pages:</div>
    @csrf
    @method('put')
    <div>
        @if (isset($qty_temp_files))
            @for ($order = 1; $order <= $qty_temp_files; $order++)
                @include('manga.management._partials.img_displayer_container')
            @endfor
        @else
            @foreach($chapter->pages as $order => $page)
                @include('manga.management._partials.img_displayer_container')
            @endforeach
        @endif
    </div>
    <div class="text-end mt-4">
        <span class="btn-group" role="group">
            <a href="{{ isset($qty_temp_files) ? route('chapter.upload.cancel', $manga) : route('manga.edit', $chapter->manga) }}" class="btn btn-danger text-light">{{ isset($qty_temp_files) ? 'Cancel' : 'Return' }}</a>
            <button class="btn btn-primary text-light" type="submit">{{ Request::routeIs('chapter.edit') ? 'Edit' : 'Edit Order' }}</button>
            @if (isset($qty_temp_files))
                <button formaction="{{ route('chapter.upload.finish', $manga) }}"
                    class="btn btn-success text-light"
                    {{ $qty_temp_files < 2 || isset($chapter) && $chapter->pages->count() < 2 ? 'disabled' : null }}
                >
                    Upload
                </button>
            @endif
        </span>
    </div>
</form>
<form action="{{ isset($qty_temp_files) ? route('page.onUpload.add', $manga) : route('page.onEdit.add', $chapter) }}" method="post" enctype="multipart/form-data">
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