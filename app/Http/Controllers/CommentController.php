<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCommentRequest;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\User;
use App\Utils\CacheNames;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(int $id_chapter, StoreUpdateCommentRequest $req)
    {
        $this->authorize('create', Comment::class);
        
        if(!$chapter = Chapter::find($id_chapter))
            return back();
        
        auth()->user()->comments()->create([
            'id_user' => auth()->id(),
            'id_chapter' => $id_chapter,
            'body' => $req->body,
        ]);

        cache()->forget(CacheNames::chapterComments($chapter->id));

        return back();
    }

    public function update(Comment $comment, StoreUpdateCommentRequest $req)
    {
        $this->authorize('update', $comment);

        $comment->update($req->only('body'));
        $chapter = $comment->chapter;

        cache()->forget(CacheNames::chapterComments($chapter->id));

        return redirect(route('app.manga.view', ['id' => $chapter->id_manga, 'chapter_order' => $chapter->order]) . "#$comment->id");
    }

    public function delete(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        cache()->forget(CacheNames::chapterComments($comment->id_chapter));

        return back();
    }
}
