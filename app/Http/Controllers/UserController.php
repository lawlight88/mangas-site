<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function profile(int $id)
    {
        if(!$user = User::withRecentComments()->find($id))
            return back();

        return view('user.profile', compact('user'));
    }

    public function edit(int $id)
    {
        if(!$user = User::find($id))
            return back();

        return view('user.edit', compact('user'));
    }
}
