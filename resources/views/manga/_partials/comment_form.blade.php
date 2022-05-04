@include('includes.validation-form')
<form action="{{ isset($comment->id) ? route('comment.update', $comment->id) : route('comment.store', ['id_user' => Auth::id(), 'id_chapter' => $manga->chapters->first()->id ]) }}" method="post">
    @csrf
    @if (isset($comment->id))
        @method('put')
    @endif
    <textarea class="form-control" name="body" placeholder="Comment..." rows="3">{{ $comment->body ?? old('body') }}</textarea>
    <div class="d-flex justify-content-end mt-2">
        <button class="btn btn-light" type="submit">Submit</button>
    </div>
</form>