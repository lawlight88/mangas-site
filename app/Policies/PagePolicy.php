<?php

namespace App\Policies;

use App\Models\Chapter;
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
}
