<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    public function profile(int $id)
    {
        if(!$user = User::withRecentComments()->find($id))
            return back();
        
        return view('user.profile', compact('user'));
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
}
