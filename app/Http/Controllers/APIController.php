<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateCommentRequest;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Manga;
use App\Models\Role;
use App\Models\User;
use CyrildeWit\EloquentViewable\Support\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class APIController extends Controller
{
    public function mangas(int $id_manga = null)
    {
        if($id_manga) {
            $manga = Manga::withCount('chapters')->find($id_manga);
            return $manga ?? ['Result' => 'Manga not found'];
        }

        return Manga::withCount('chapters')->orderByViews('desc', Period::subDays(7))->paginate(10);
    }

    public function mangasSearch(string $search)
    {
        $mangas = Manga::searchBy($search);
        return count($mangas) ? $mangas : ['Result' => 'No records found'];
    }

    public function mangaTempFiles(int $id_manga)
    {
        if(!$manga = Manga::find($id_manga))
        {
            return response(['Result' => 'Manga not found']);
        }
        if($manga->id_scanlator != auth()->user()->id_scanlator
            && auth()->user()->role != Role::IS_ADMIN)
        {
            return response(['message' => 'Unauthorized'], 401);
        }

        $qty_temp_files = count(Storage::disk('temp')->allFiles($id_manga));
        if(!$qty_temp_files)
        {
            return response(['Result' => "Manga's temp folder is empty"], 200);
        }
        for($i = 1; $i <= $qty_temp_files; $i++)
        {
            $response["page_$i"] = route('page.display', [
                'manga' => $manga,
                'order' => $i
            ]);
        }

        return response($response, 200);
    }

    public function chapters(int $id_manga)
    {
        $chapters = Chapter::with('pages')->where('id_manga', $id_manga)->paginate(10);
        if(!$chapters->first())
        {
            return response(['Result' => 'Given manga does not have chapters'], 404);
        }

        return response($chapters, 200);
    }

    public function chaptersComments(int $id_manga, int $chapter_order)
    {
        $chapter = Chapter::chapterComments($id_manga, $chapter_order);
        if(!$chapter)
        {
            return response(['Result' => 'Chapter not found'], 404);
        }
        $comments = $chapter->comments;
        if(!$comments->first())
        {
            return response(['Result' => 'Chapter does not have any comment'], 200);
        }

        return response($comments, 200);
    }

    public function createComment(int $id_manga, int $chapter_order, StoreUpdateCommentRequest $req)
    {
        $chapter = Chapter::whereMangaChapterOrder($id_manga, $chapter_order)->first();
        if(!$chapter)
        {
            return response(['Result' => 'Chapter not found'], 404);
        }
        $comment = Comment::create([
            'id_chapter' => $chapter->id,
            'id_user' => auth()->user()->id,
            'body' => $req->body
        ]);

        return response(['comment' => $comment], 201);
    }

    public function commentEdit(int $id_comment, StoreUpdateCommentRequest $req)
    {
        if(!$comment = Comment::find($id_comment))
        {
            return response(['Result' => 'Comment not found'], 404);
        }
        if($comment->id_user != auth()->user()->id
            && auth()->user()->role != Role::IS_ADMIN)
        {
            return response(['message' => 'Unauthorized'], 401);
        }
        $comment->update([
            'body' => $req->body
        ]);

        return response(['Result' => 'Comment successfully edited'], 200);
    }

    public function commentDelete(int $id_comment)
    {
        if(!$comment = Comment::find($id_comment))
        {
            return response(['Result' => 'Comment not found'], 404);
        }
        if($comment->id_user != auth()->user()->id
            && auth()->user()->role != Role::IS_ADMIN)
        {
            return response(['message' => 'Unauthorized'], 401);
        }
        $comment->delete();

        return response(['Result' => 'Comment was successfully deleted'], 200);
    }

    public function userComments(int $id_user)
    {
        if(!$user = User::with('comments')->find($id_user))
        {
            return response(['Result' => 'User not found'], 404);
        }
        $comments = $user->comments()->paginate(10);
        if(!$comments->first())
        {
            return response(['Result' => 'User does not have comments'], 200);
        }

        return response(['comments' => $comments], 200);
    }

    public function userFavorites(int $id_user)
    {
        if(!$user = User::find($id_user))
        {
            return response(['Result' => 'User not found'], 404);
        }
        if(auth()->id() == $user->id
            || auth()->user()->role == Role::IS_ADMIN)
        {
            $favorites = $user->favorites()->paginate(10);
        }
        else
        {
            $favorites = $user->favorites()->limit(4)->get();
        }
        if(!$favorites->first())
        {
            return response(['Result' => 'User does not have favorites'], 200);
        }

        return response(['favorites' => $favorites], 200);
    }

}
