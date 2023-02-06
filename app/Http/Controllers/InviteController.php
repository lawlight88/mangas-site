<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\Role;
use App\Models\User;
use App\Utils\CacheNames;
use Illuminate\Support\Facades\Auth;

class InviteController extends Controller
{
    public function create(int $id_invited)
    {
        if(!$invited_user = User::onlyIdRole()->find($id_invited))
            return back();

        $this->authorize('create', [Invite::class, $invited_user]);

        Invite::create([
            'id_scanlator' => Auth::user()->id_scanlator,
            'id_invited' => $id_invited
        ]);

        cache()->forget(CacheNames::invites($id_invited));

        return back();
    }

    public function cancel(int $id_invite)
    {
        if(!$invite = Invite::find($id_invite))
            return back();

        $this->authorize('cancel', $invite);

        $id_invited = $invite->id_invited;
        $invite->delete();

        cache()->forget(CacheNames::invites($id_invited));

        return back();
    }

    public function refuse(int $id_invite)
    {
        if(!$invite = Invite::find($id_invite))
            return back();

        $this->authorize('refuse', $invite);

        $invite->update([
            'response' => false
        ]);

        cache()->forget(CacheNames::invites($invite->id_invited));

        return back();
    }

    public function accept(int $id_invite)
    {
        if(!$invite = Invite::find($id_invite))
            return back();

        $this->authorize('accept', $invite);

        $user = User::with('invites')->find(Auth::id());

        $user->update([
            'id_scanlator' => $invite->id_scanlator,
            'role' => Role::IS_SCAN_HELPER,
            'joined_scan_at' => now()
        ]);

        $user->deleteInvites();

        cache()->forget(CacheNames::invites($user->id));

        return back();
    }
}
