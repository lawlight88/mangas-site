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
        return $user->role == Role::IS_SCAN_LEADER && $invited_user->role == Role::IS_USER;
    }

    public function cancel(User $user, Invite $invite)
    {
        return $user->role == Role::IS_SCAN_LEADER && $invite->id_scanlator == $user->id_scanlator;
    }
}