<div class="row bg-dark-1 p-4 mx-1">
    <div class="col-md-4">
        <img src="{{ asset($scan->image) }}" alt="scan image" class="img-fluid">
    </div>
    <div class="col-md-8">
        <div class="d-flex justify-content-between">
            <span>Name: {{ $scan->name }}</span>
            <small class="text-white-50">Created At: {{ Timezone::convertToLocal($scan->created_at, 'Y-m-d H:i') }}</small>
        </div>
        @if ($scan->desc)
            <div>
                <div>Description:</div>
                <div class="px-3 py-1">
                    {{ $scan->desc }}
                </div> 
            </div>
        @endif
        <div>Leader: <a class="text-light" href="{{ route('user.profile', $scan->leader->id) }}">{{ $scan->leader->name }}</a></div>
        <div class="row">
            <div class="col-md-9">
                <a href="{{ route('app.scan.mangas', $scan->id) }}" class="text-decoration-none text-info">Mangas: </a>
                @if (empty($scan->mangas->first()))
                    <span class="text-warning">None</span>
                @else
                    @foreach ($scan->mangas as $key => $manga)
                        <a href="{{ route('app.manga.main', $manga->id) }}" class="text-light">{{ $manga->name }}</a>
                        {{ ($key+1) != $scan->mangas->count() ? ',' : null }}
                        {{ ($key+1) == $scan->mangas->count() && ($key+1) != $scan->mangas_count ? '...' : null }}
                    @endforeach
                @endif
            </div>
            @can('update', $scan)
                <div class="col-md-3 d-flex justify-content-end">
                    <a href="{{ route('scan.edit', $scan->id) }}" class="btn btn-info text-light">Edit</a>
                </div>
            @endcan
        </div>
    </div>
    <div class="col-12 mt-3">
        <div class="list-group">
            @foreach ($scan->members as $member)
                <div class="list-group-item list-group-item-action flex-column align-items-start bg-light-1">
                    <div class="d-flex w-100 justify-content-between">
                        <a href="{{ route('user.profile', $member->id) }}" class="h5 mb-1 text-decoration-none text-dark">
                            {{$member->name}}
                            @if ($member->id == $scan->leader->id)
                                <i class="text-warning fa-sm fa-spin fa-solid fa-star"></i>
                            @endif
                        </a>
                        <small class="text-black-50">Joined At: {{ Timezone::convertToLocal($member->joined_scan_at, 'Y-m-d H:i') }}</small>
                    </div>
                    <div class="row">
                        <div class="col-9">
                            <span class="mb-1">{{ $member->scan_role }}</span>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            @if (!isset($member_edit) && Request::routeIs('scan.view'))
                                <form action="{{ route('user.scan.remove', $member->id) }}" method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    @can('changeLeader', $member)
                                        <button formaction="{{ route('user.scan.change.leader', $member) }}" title="Pass the lead" type="submit" class="btn fa d-inline"><i class="text-warning fa-sm fa-solid fa-star"></i></button>
                                    @endcan
                                    @can('editScanRole', $member)
                                        <a href="{{ route('scan.view', ['id_scan' => $scan->id, 'member_edit' => $member]) . "#$member->id" }}" title="Edit role" class="text-light btn fa d-inline"><i class="fas fa-edit fa-sm text-primary"></i></a>
                                    @endcan
                                    @can('removeFromScan', $member)
                                        <button type="submit" title="Kick off" class="text-light btn fa d-inline"><i class="fa-solid fa-sm fa-x text-danger"></i></button>
                                    @endcan
                                </form>
                            @endif
                        </div>
                        @if (isset($member_edit) && Request::routeIs('scan.view') && $member_edit->id == $member->id && Auth::user()->can('editScanRole', $member_edit))
                            <div class="col-9">
                                <form action="{{ route('user.scan.role.edit', $member) }}" method="post">
                                    @csrf
                                    @method('put')
                                    <div class="input-group">
                                        <textarea name="scan_role" id="{{ $member->id }}" maxlength="20" cols="25" rows="1">{{ $member->scan_role }}</textarea>
                                        <button class="btn btn-dark btn-sm" type="submit">Edit</button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="d-flex justify-content-center mt-3">
        {{ $scan->members->links() }}
    </div>
</div>