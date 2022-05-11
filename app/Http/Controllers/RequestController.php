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

        if(!$scan = Scanlator::withPendingRequests()->find(Auth::user()->id_scanlator))
            return back();

        return view('manga.management.scan_requests', compact('scan'));
    }

    public function adminRequests()
    {
        $this->authorize('adminRequests', ModelsRequest::class);

        $requests = ModelsRequest::pendingRequests()->get();

        return view('manga.management.admin_requests', compact('requests'));
    }

    public function accept(int $id_req)
    {
        $this->authorize('accept', ModelsRequest::class);

        if(!$request = ModelsRequest::with('manga')->find($id_req))
            return back();

        $request->update([
            'status' => true
        ]);
        $request->manga->update([
            'id_scanlator' => $request->id_requester
        ]);

        return back();
    }

    public function refuse(int $id_req)
    {
        $this->authorize('accept', ModelsRequest::class);

        if(!$request = ModelsRequest::find($id_req))
            return back();

        $request->update([
            'status' => false
        ]);

        return back();
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

    public function history()
    {
        $this->authorize('history', ModelsRequest::class);

        if(Auth::user()->role == Role::IS_ADMIN) {

            $requests = ModelsRequest::adminAnsweredRequests()->get();

        } else {
            
            $requests = ModelsRequest::answeredRequests(Auth::user()->id_scanlator)->get();

        }

        return view('manga.management.history', compact('requests'));
    }
}
