<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCommentRequest;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(int $id_chapter, StoreUpdateCommentRequest $req)
    {
        $this->authorize('create', Comment::class);
        
        $id = Auth::id();
        $user = User::find($id);
        //need to use User::find() instead of Auth::user()
        //in order to create the comment

        if(!Chapter::find($id_chapter))
            return back();
        
        $user->comments()->create([
            'id_user' => $id,
            'id_chapter' => $id_chapter,
            'body' => $req->body,
        ]);

        return back();
    }

    public function update(Comment $comment, StoreUpdateCommentRequest $req)
    {
        $this->authorize('update', $comment);

        $comment->update($req->only('body'));
        $comment->chapter;
        
        return redirect(route('app.manga.view', ['id' => $comment->chapter->id_manga, 'chapter_order' => $comment->chapter->order]) . "#$comment->id");
    }

    public function delete(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();

        return back();
    }
}
