<?php

namespace App\Policies;

use App\Models\Invite;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class InvitePolicy
{
    use HandlesAuthorization;
    
    public function create(User $user, User $invited_user)
    {
        return $user->role == Role::IS_SCAN_LEADER && $user->id != $invited_user->id && $invited_user->role == Role::IS_USER;
    }

    public function cancel(User $user, Invite $invite)
    {
        return $user->role == Role::IS_SCAN_LEADER && $invite->id_scanlator == $user->id_scanlator;
    }

    public function view(User $user, User $profile_user)
    {
        return $user->id == $profile_user->id && $user->role == Role::IS_USER;
    }

    public function accept(User $user, Invite $invite)
    {
        return $user->id == $invite->id_invited && $user->role == Role::IS_USER;
    }

    public function refuse(User $user, Invite $invite)
    {
        return self::accept($user, $invite);
    }
}