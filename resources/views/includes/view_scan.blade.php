<div class="row bg-dark-1 p-4 mx-1">
    <div class="col-md-4">
        <img src="{{ asset($scan->image) }}" alt="scan image" class="img-fluid">
    </div>
    <div class="col-md-8">
        <div class="d-flex justify-content-between">
            <span>Name: {{ $scan->name }}</span>
            <small class="text-white-50">Created At: {{ $scan->created_at->format('Y-m-d H:i') }}</small>
        </div>
        @if ($scan->desc)
            <div>
                <div>Description:</div>
                <div class="px-3 py-1">
                    {{ $scan->desc }}
                </div> 
            </div>
        @endif
        <div>Leader: <a class="text-info" href="{{ route('user.profile', $scan->leader->id) }}">{{ $scan->leader->name }}</a></div>
        <div class="d-flex justify-content-between">
            <span>Main Mangas: ...</span>
            @can('update', $scan)
                <a href="{{ route('scan.edit', $scan->id) }}" class="btn btn-info text-light">Edit</a>
            @endcan
        </div>
    </div>
    <div class="col-12 mt-3">
        @foreach ($scan->members as $member)
            <div class="list-group">
                <div href="#" class="list-group-item list-group-item-action flex-column align-items-start bg-light-1">
                    <div class="d-flex w-100 justify-content-between">
                        <a href="#" class="h5 mb-1 text-decoration-none text-dark">
                            {{$member->name}}
                            @if ($member->id == $scan->leader->id)
                                <i class="text-warning fa-sm fa-spin fa-solid fa-star"></i>
                            @endif
                        </a>
                        <small class="text-black-50">Joined At: {{$member->joined_scan_at->format('Y-m-d H:i')}}</small>
                    </div>
                    <div class="row">
                        <div class="col-9">
                            <span class="mb-1">{{ $member->scan_role }}</span>
                        </div>
                        <div class="col-3 d-flex justify-content-end">
                            @if (!$member_edit)
                                <form action="{{ route('user.scan.remove', $member->id) }}" method="post" class="d-inline">
                                    @method('put')
                                    @csrf
                                    @can('editScanRole', $member)
                                        <a href="{{ route('scan.view', ['id_scan' => $scan->id, 'member_edit' => $member]) . "#$member->id" }}" class="text-light btn fa d-inline"><i class="fas fa-edit fa-sm text-primary"></i></a>
                                    @endcan
                                    @can('removeFromScan', $member)
                                        <button type="submit" class="text-light btn fa d-inline"><i class="fa-solid fa-sm fa-x text-danger"></i></button>
                                    @endcan
                                </form>
                            @endif
                        </div>
                        @if ($member_edit && $member_edit->id == $member->id && Auth::user()->can('editScanRole', $member_edit))
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
            </div>
        @endforeach
    </div>
    <div class="d-flex justify-content-center mt-3">
        {{ $scan->members->links() }}
    </div>
</div>