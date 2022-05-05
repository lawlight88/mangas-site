<div class="p-2 mb-3">
    <div class="row">
        <div class="col-1">
            <img class="rounded-circle" src="{{ Request::is('m/*') ? asset($comment->user->profile_image) : asset($user->profile_image) }}" width="100" height="100" alt="">
        </div>
        <div class="offset-2 col-9 offset-sm-1 col-sm-10 offset-lg-0 col-lg-11">
            <div class="d-flex justify-content-between py-2 px-4">
                <a class="text-decoration-none text-light h5" href="{{ Request::is('m/*') ? route('user.profile', $comment->user->id) : route('app.manga.view', ['id' => $comment->chapter->id_manga, 'chapter_order' => $comment->chapter->order]) . "#$comment->id" }}">
                    @if ($comment->user->id == Auth::id())
                        Me
                    @else
                        {{$comment->user->name}}
                    @endif
                </a>
                <span>
                    @if ($comment->updated_at > $comment->created_at)
                        <small>(edited)</small>
                    @endif
                    {{$comment->created_at->format('Y-m-d H:i')}}
                </span>
            </div>
            <div class="py-2 px-4" id="{{ $comment->id }}">
                {{$comment->body}}
            </div>
            
            @if (Request::is('m/*') && Auth::id() == $comment->id_user)
                @if ($id_comment_edit == $comment->id)
                    @include('manga._partials.comment_form')
                @endif
                @if (is_null($id_comment_edit))
                    <div class="text-end">
                        <form action="{{ route('comment.delete', $comment->id) }}" method="post">
                            @method('delete')
                            @csrf
                            <a class="text-light btn btn-lg fa-lg d-inline-block" href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter_order, 'page_order' => $page->order, 'id_comment_edit' => $comment->id]) . "#$comment->id" }}"><i class="fas fa-edit"></i></a>
                            <button type="submit" class="text-light btn btn-lg fa-lg d-inline-block mx-4"><i class="fa-solid fa-x"></i></button>
                        </form>
                    </div>
                @endif
            @endif
        </div>
    </div>
</div>