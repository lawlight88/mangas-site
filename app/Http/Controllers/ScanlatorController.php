<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateScanlatorRequest;
use App\Models\Scanlator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ScanlatorController extends Controller
{
    public function index()
    {
        $scans = Scanlator::getIndexScans();
        
        return view('manga.management.index', compact('scans'));
    }

    public function scanView(int $id_scan)
    {
        if(!$scan = Scanlator::find($id_scan))
            return back();

        return view('manga.management.view_scan', compact('scan'));
    }

    public function create()
    {
        return view('manga.management.create_scan');
    }

    public function store(StoreUpdateScanlatorRequest $req)
    {
        $id_leader = Auth::id();
        $leader = User::find($id_leader);

        $data = $req->all();
        $data['leader'] = $id_leader;

        $path = $req->image->store("scans/$req->name");
        $data['image'] = "storage/$path";

        $scan = Scanlator::create($data);
        $leader->update([
            'scanlator' => $scan->id
        ]);

        return redirect()->route('scan.index');
    }

    public function update(StoreUpdateScanlatorRequest $req)
    {
        dd($req->all());
    }
}
