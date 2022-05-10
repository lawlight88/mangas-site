<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\Scanlator;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class ScanlatorPolicy
{
    use HandlesAuthorization;

    public function create(User $user)
    {
        return is_null($user->scanlator);
    }

    public function view(User $user)
    {
        return $user->role == Role::IS_ADMIN || !is_null($user->scanlator);
    }

    public function adminAllScans(User $user)
    {
        return $user->role == Role::IS_ADMIN;
    }

    // public function update(User $user, Scanlator $scan)
    // {
    //     return $user->role == Role::IS_ADMIN || $scan->leader == $user->id;
    // }
    
}
