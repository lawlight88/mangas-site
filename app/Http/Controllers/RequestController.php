<?php

namespace App\Http\Controllers;

use App\Models\Manga;
use App\Models\Request as ModelsRequest;
use App\Models\Role;
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

    public function cancel(int $id_req)
    {
        $this->authorize('cancel', ModelsRequest::class);

        if(!$req = ModelsRequest::dontSelectVisibleColumns()->find($id_req))
            return back();

        if(is_null($req->status))
            $req->delete();

        return back();
    }

    public function delete(int $id_req)
    {
        $this->authorize('delete', ModelsRequest::class);

        if(!$req = ModelsRequest::find($id_req))
            return back();

        if(Auth::user()->role == Role::IS_ADMIN) {
            $req->update([
                'visible_admin' => false
            ]);
        }
        if(Auth::user()->role == Role::IS_SCAN_LEADER) {
            $req->update([
                'visible_scan' => false
            ]);
        }
        dd($req);
        if(!$req->visible_admin && !$req->visible_scan)
            $req->delete();

        return back();
    }
}
