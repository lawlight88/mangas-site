<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class CommentPolicy
{
    use HandlesAuthorization;

    public function create()
    {
        return Auth::check();
    }

    public function update(User $user, Comment $comment)
    {
        return $user->role == Role::IS_ADMIN || $user->id == $comment->id_user;
    }

    public function delete(User $user, Comment $comment)
    {
        return self::update($user, $comment);
    }
}
