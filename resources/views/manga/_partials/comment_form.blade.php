@include('includes.validation-form')
<form action="{{ isset($comment) ? route('comment.update', $comment) : route('comment.store', $manga->chapters->first()->id) }}" method="post">
    @csrf
    @if (isset($comment))
        @method('put')
    @endif
    <textarea class="form-control" id="{{ isset($comment) ? "c_$comment->id" : '' }}" name="body" placeholder="Comment..." rows="3">{{ $comment->body ?? old('body') }}</textarea>
    <div class="d-flex justify-content-end mt-2">
        <button class="btn btn-light" type="submit">Submit</button>
    </div>
</form>