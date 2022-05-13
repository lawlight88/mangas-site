<form action="{{ Request::routeIs('scan.view') ? route('scan.update', $scan) : route('scan.create') }}" method="post" enctype="multipart/form-data">
    @csrf
    @if (Request::routeIs('scan.view'))
        @method('put')
    @endif
    <div class="row justify-content-center">
        <div class="col-md-5">

            @include('includes.validation-form')


            <label for="name">Name:</label><br>
            <input class="form-control" type="text" name="name" id="name" value="{{ $scan->name ?? old('name') }}" {{ Request::routeIs('scan.edit') ? 'disabled' : '' }}><br>
            <label for="desc">Description:</label><br>
            <textarea class="form-control" name="desc" id="desc" placeholder="(Optional)" rows="3">{{ $scan->desc ?? old('desc') }}</textarea><br>
            <label for="pages">Image:</label><br>
            <input class="form-control" type="file" name="image" id="image"><br>

            <div class="d-flex justify-content-center mb-4">
                <button class="btn btn-light" type="submit">Submit</button>
            </div>

        </div>
    </div>

</form>