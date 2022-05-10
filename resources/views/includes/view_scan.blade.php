<div class="row bg-dark-1 p-4 mb-4">
    <div class="col-md-4">
        <img src="{{ asset($scan->image) }}" alt="scan image" class="img-fluid">
    </div>
    <div class="col-md-8">
        <div>Name: {{ $scan->name }}</div>
        <div>Created At: {{ $scan->created_at->format('Y-m-d H:i') }}</div>
        <div>Leader: <a class="text-secondary" href="{{ route('user.profile', $scan->leader->id) }}">{{ $scan->leader->name }}</a></div>
    </div>
</div>
{{-- members... --}}