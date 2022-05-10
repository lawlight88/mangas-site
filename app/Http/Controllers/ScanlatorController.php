<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateScanlatorRequest;
use App\Models\Scanlator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

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

        $path = $req->image->store("scans/$req->name");
        $data['image'] = "storage/$path";

        $scan = Scanlator::create($data);
        $leader->update([
            'scanlator' => $scan->id
        ]);

        return redirect()->route('app.index');
    }

    public function update(StoreUpdateScanlatorRequest $req)
    {
        // $this->authorize('update', $scan);

        dd($req->all());
    }
}
