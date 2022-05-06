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
        $id = Auth::id();
        if(!$user = User::find($id))
            return back();

        if(!Chapter::find($id_chapter))
            return back();
        
        $user->comments()->create([
            'id_user' => $id,
            'id_chapter' => $id_chapter,
            'body' => $req->body,
        ]);

        return back();
    }

    public function update(int $id_comment, StoreUpdateCommentRequest $req)
    {
        if(!$comment = Comment::withRedirectParams()->find($id_comment))
            return back();

        $comment->update($req->only('body'));
        
        return redirect(route('app.manga.view', ['id' => $comment->chapter->id_manga, 'chapter_order' => $comment->chapter->order]) . "#$comment->id");
    }

    public function delete(int $id)
    {
        if(!$comment = Comment::find($id))
            return back();

        $comment->delete();

        return back();
    }
}
