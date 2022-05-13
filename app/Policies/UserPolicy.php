<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function removeFromScan(User $user, User $scan_member)
    {
        return $user->role == Role::IS_SCAN_LEADER && $user->id == $scan_member->scanlator->id_leader && $scan_member->role == Role::IS_SCAN_HELPER;
    }

    public function editScanRole(User $user, User $scan_member)
    {
        return $user->role == Role::IS_SCAN_LEADER && $user->id == $scan_member->scanlator->id_leader;
    }
}
