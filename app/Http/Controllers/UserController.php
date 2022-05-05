<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

    public function update(int $id, UpdateUserRequest $req)
    {
        if(!$user = User::find($id))
            return back();

        $storage_dir = "users/$id";
        $dir_local = public_path("storage/$storage_dir");
        if(isset($req->profile_image)) {
            if(!file_exists($dir_local))
                mkdir($dir_local, 0777, true);
                
            File::cleanDirectory($dir_local);
            $path = $req->profile_image->store($storage_dir);
            $path = "storage/$path";
        }

        $user->update([
            'name' => $req->name,
            // 'show_favorites' => isset($req->favorites) ? false : true,
            // 'show_comments' => isset($req->comments) ? false : true,
            'profile_image' => $path ?? $user->profile_image,
        ]);

        return redirect()->route('user.profile', $id);
    }
}
