<div class="row bg-dark-1 p-4 mx-1">
    <div class="col-md-4">
        <img src="{{ asset($scan->image) }}" alt="scan image" class="img-fluid">
    </div>
    <div class="col-md-8">
        <div>Name: {{ $scan->name }}</div>
        @if ($scan->desc)
            <div>
                <div>Description:</div>
                <div class="px-3 py-1">
                    {{ $scan->desc }}
                </div> 
            </div>
        @endif
        <div>Leader: <a class="text-info" href="{{ route('user.profile', $scan->leader->id) }}">{{ $scan->leader->name }}</a></div>
        <div><small class="text-white-50">Created At: {{ $scan->created_at->format('Y-m-d H:i') }}</small></div>
    </div>
</div>
{{-- members... --}}