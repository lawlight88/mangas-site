<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreScanlatorRequest;
use App\Http\Requests\UpdateScanlatorRequest;
use App\Models\Manga;
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

    public function view(int $id_scan)
    {
        if(!$scan = Scanlator::withScanInfo()->find($id_scan))
            return back();

        $scan->members = $scan->membersPaginate();

        return view('view_scan', compact('scan'));
    }

    public function mgmtScanView(int $id_scan, User $member_edit = null)
    {
        $this->authorize('view', Scanlator::class);
        if($member_edit)
            $this->authorize('editScanRole', $member_edit);

        if(!$scan = Scanlator::withScanInfo()->find($id_scan))
            return back();

        $scan->members = $scan->membersPaginate();

        return view('manga.management.view_scan', compact('scan', 'member_edit'));
    }

    public function create()
    {
        $this->authorize('create', Scanlator::class);        

        return view('manga.management.create_scan');
    }

    public function store(StoreScanlatorRequest $req)
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
            'id_scanlator' => $scan->id,
            'role' => Role::IS_SCAN_LEADER,
            'joined_scan_at' => now(),
            'scan_role' => 'Leader'
        ]);

        return redirect()->route('app.index');
    }

    public function edit(int $id_scan)
    {
        if(!$scan = Scanlator::find($id_scan))
            return back();

        $this->authorize('update', $scan);

        return view('manga.management.edit_scan', compact('scan'));
    }

    public function update(Scanlator $scan, UpdateScanlatorRequest $req)
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
                'id_scanlator' => null,
                'role' => Role::IS_USER,
                'joined_scan_at' => null,
                'scan_role' => null
            ]);
        }

        $scan->delete();

        return redirect()->route('app.index');
    }

    public function mangasView(int $id_scan)
    {
        if(!$scan = Scanlator::select('id', 'name')->find($id_scan))
            return back();

        $scan->mangas = $scan->mangasPaginate();

        return view('scan_mangas', compact('scan'));
    }

    public function mgmtMangasView(int $id_scan)
    {
        $this->authorize('mgmtMangasView', [Scanlator::class, $id_scan]);

        if(!$scan = Scanlator::select('id', 'name')->find($id_scan))
            return back();

        $scan->mangas = $scan->mangasPaginate();

        return view('manga.management.scan_mangas', compact('scan'));
    }

    public function removeManga(Scanlator $scan, Manga $manga)
    {
        $this->authorize('removeManga', [$scan, $manga]);

        $manga->update([
            'id_scanlator' => null
        ]);
        
        return back();
    }
}
