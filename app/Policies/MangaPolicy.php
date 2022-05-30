<?php

namespace App\Policies;

use App\Models\Manga;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MangaPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Manga $manga)
    {
        return in_array($user->role, [Role::IS_SCAN_HELPER, Role::IS_SCAN_LEADER])
                && $user->id_scanlator == $manga->id_scanlator
                || $user->role == Role::IS_ADMIN;
    }

    public function removeFromScan(User $user, Manga $manga)
    {
        return $user->role == Role::IS_SCAN_LEADER 
                && $user->id_scanlator == $manga->id_scanlator
                || $user->role == Role::IS_ADMIN;
    }

    public function editInfo(User $user, Manga $manga)
    {
        return self::removeFromScan($user, $manga);
    }

    public function create(User $user)
    {
        return $user->role = Role::IS_ADMIN;
    }
}
