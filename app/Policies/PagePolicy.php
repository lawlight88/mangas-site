<?php

namespace App\Policies;

use App\Models\Chapter;
use App\Models\Manga;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PagePolicy
{
    use HandlesAuthorization;

    public function removeOnEdit(User $user, Chapter $chapter)
    {
        return in_array($user->role, [Role::IS_SCAN_HELPER, Role::IS_SCAN_LEADER])
                && $user->id_scanlator == $chapter->manga->id_scanlator
                || $user->role == Role::IS_ADMIN;
    }

    public function orderOnEdit(User $user, Chapter $chapter)
    {
        return self::removeOnEdit($user, $chapter);
    }
    
    public function orderOnUpload(User $user, Manga $manga)
    {
        return in_array($user->role, [Role::IS_SCAN_HELPER, Role::IS_SCAN_LEADER])
                && $user->id_scanlator == $manga->id_scanlator
                || $user->role == Role::IS_ADMIN;
    }
}
