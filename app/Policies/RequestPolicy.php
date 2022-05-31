<?php

namespace App\Policies;

use App\Models\Manga;
use App\Models\Role;
use App\Models\Scanlator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RequestPolicy
{
    use HandlesAuthorization;

    public function request(User $user, Manga $manga)
    {
        return $user->role == Role::IS_SCAN_LEADER && is_null($manga->id_scanlator)
                                                    && $manga->ongoing;
    }

    public function scanRequests(User $user)
    {
        return in_array($user->role, [Role::IS_SCAN_HELPER, Role::IS_SCAN_LEADER]);
    }

    public function accept(User $user)
    {
        return $user->role == Role::IS_ADMIN;
    }

    public function refuse(User $user)
    {
        return self::accept($user);
    }

    public function adminRequests(User $user)
    {
        return self::accept($user);
    }

    public function cancel(User $user)
    {
        return $user->role == Role::IS_SCAN_LEADER;
    }

    public function history(User $user)
    {
        return in_array($user->role, [Role::IS_ADMIN, Role::IS_SCAN_LEADER, Role::IS_SCAN_HELPER]);
    }
}
