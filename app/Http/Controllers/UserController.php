<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserUpdateScanRoleRequest;
use App\Models\Invite;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function profile(int $id)
    {
        if(!$user = User::withInfo()->find($id))
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
        $user = User::with('comments:id,id_user,id_chapter')->find($id);
        $this->authorize('update', $user);

        $data = $req->only('name');
        
        if(in_array($req->timezone, timezone_identifiers_list()))
            $data['timezone'] = $req->timezone;

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

        $user->comments->map(function($i) {
            cache()->forget("chapter-$i->id_chapter-comments");
        });

        return redirect()->route('user.profile', $id);
    }

    public function editScanRole(User $member, UserUpdateScanRoleRequest $req)
    {
        $this->authorize('editScanRole', $member);

        $member->update($req->only('scan_role'));

        return redirect()->route('scan.view', $member->id_scanlator);
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

    public function changeLeader(User $member)
    {
        $this->authorize('changeLeader', $member);

        $member->becomeLeader();

        return back();
    }
}
