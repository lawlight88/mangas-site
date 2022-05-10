<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateScanlatorRequest;
use App\Models\Role;
use App\Models\Scanlator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ScanlatorController extends Controller
{
    public function allScans()
    {
        $scans = Scanlator::getIndexScans();
        
        return view('all_scans', compact('scans'));
    }

    public function adminAllScans()
    {
        $this->authorize('adminAllScans', Scanlator::class);

        $scans = Scanlator::getIndexScans();
        
        return view('manga.management.all_scans', compact('scans'));
    }

    public function view(Scanlator $scan)
    {
        $scan->leader;

        return view('view_scan', compact('scan'));
    }

    public function mgmtScanView(int $id_scan)
    {
        $this->authorize('view', Scanlator::class);

        if(!$scan = Scanlator::withLeader()->find($id_scan))
            return back();

        return view('manga.management.view_scan', compact('scan'));
    }

    public function create()
    {
        $this->authorize('create', Scanlator::class);        

        return view('manga.management.create_scan');
    }

    public function store(StoreUpdateScanlatorRequest $req)
    {
        $this->authorize('create', Scanlator::class);

        $id_leader = Auth::id();
        $leader = User::find($id_leader);

        $data = $req->all();
        $data['id_leader'] = $id_leader;

        $path = $req->image->store("scans/$req->id");
        $data['image'] = "storage/$path";

        $scan = Scanlator::create($data);
        $leader->update([
            'scanlator' => $scan->id,
            'role' => Role::IS_SCAN_LEADER,
        ]);

        return redirect()->route('app.index');
    }

    public function update(Scanlator $scan, StoreUpdateScanlatorRequest $req)
    {
        $this->authorize('update', $scan);

        $data = $req->only('name', 'desc');

        $storage_dir = "scans/$scan->id";
        $dir_local = public_path("storage/$storage_dir");
        if(isset($req->image)) {
            if(!file_exists($dir_local))
                mkdir($dir_local, 0777, true);
                
            File::cleanDirectory($dir_local);
            $path = $req->image->store($storage_dir);
            $path = "storage/$path";

            $data['image'] = $path;
        }

        $scan->update($data);

        return redirect()->route('scan.view', $scan->id);
    }

    public function delete(Scanlator $scan)
    {
        $this->authorize('delete', $scan);

        $members = $scan->members;
        foreach($members as $member) {
            $member->update([
                'scanlator' => null,
                'role' => Role::IS_USER,
            ]);
        }

        $scan->delete();

        return redirect()->route('app.index');
    }
}
