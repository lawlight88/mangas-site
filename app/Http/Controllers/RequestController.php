<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Request as ModelsRequest;
use App\Models\Scanlator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    public function store(int $id_manga)
    {
        $this->authorize('request', ModelsRequest::class);

        if(!$manga = Manga::select('id_scanlator')->find($id_manga))
            return back();

        if(!is_null($manga->id_scanlator))
            return back();

        if(ModelsRequest::checkIfAlreadyRequested(id_requester: Auth::user()->id_scanlator, id_manga: $id_manga))
            return back();

        ModelsRequest::create([
            'id_requester' => Auth::user()->id_scanlator,
            'id_manga' => $id_manga
        ]);

        return back();
    }

    public function scanRequests()
    {
        $this->authorize('scanRequests', ModelsRequest::class);

        if(!$scan = Scanlator::withRequests()->find(Auth::user()->id_scanlator))
            return back();

        return view('manga.management.scan_requests', compact('scan'));
    }
}
