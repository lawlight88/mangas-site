<?php

namespace App\Http\Controllers;

use App\Models\Invite;
use App\Models\User;
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

        return back();
    }

    public function cancel(int $id_invite)
    {
        if(!$invite = Invite::find($id_invite))
            return back();

        $this->authorize('cancel', $invite);

        $invite->delete();

        return back();
    }
}
