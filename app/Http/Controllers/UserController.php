<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\Invite;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function profile(int $id)
    {
        if(!$user = User::withUserInfos()->find($id))
            return back();

        $invite = null;
        if(Auth::check()) {
            if(Auth::user()->id == $user->id)
                $user->invites = User::getPendingInvites($user);

            if(Auth::user()->role == Role::IS_SCAN_LEADER)
                $invite = Invite::get(id_scanlator: Auth::user()->id_scanlator, id_invited: $id);
        }
        
        return view('user.profile', compact('user', 'invite'));
    }

    public function edit()
    {
        $user = Auth::user();

        return view('user.edit', compact('user'));
    }

    public function update(UpdateUserRequest $req)
    {
        $id = Auth::id();
        $user = User::find($id);

        $data = $req->only('name');

        if($req->password)
            $data['password'] = bcrypt($req->password);

        $storage_dir = "users/$id";
        $dir_local = public_path("storage/$storage_dir");
        if(isset($req->profile_image)) {
            if(!file_exists($dir_local))
                mkdir($dir_local, 0777, true);
                
            File::cleanDirectory($dir_local);
            $path = $req->profile_image->store($storage_dir);
            $path = "storage/$path";

            $data['profile_image'] = $path;
        }

        $user->update($data);

        return redirect()->route('user.profile', $id);
    }

    public function removeFromScan(int $id_user)
    {
        if(!$user = User::find($id_user))
            return back();

        $this->authorize('removeFromScan', $user);

        $user->update([
            'id_scanlator' => null,
            'role' => Role::IS_USER,
            'scan_role' => null
        ]);

        return back();
    }
}
