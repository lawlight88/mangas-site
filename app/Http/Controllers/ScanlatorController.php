<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateScanlatorRequest;
use App\Models\Scanlator;
use Illuminate\Support\Facades\Auth;

class ScanlatorController extends Controller
{
    public function index()
    {
        $scans = Scanlator::getIndexScans();
        
        return view('manga.management.index', compact('scans'));
    }

    public function create()
    {
        return view('manga.management.create_scan');
    }

    public function store(StoreUpdateScanlatorRequest $req)
    {
        $data = $req->all();
        $data['leader'] = Auth::id();

        $path = $req->image->store("scans/$req->name");
        $data['image'] = "storage/$path";

        Scanlator::create($data);

        return redirect()->route('scan.index');
    }
}
