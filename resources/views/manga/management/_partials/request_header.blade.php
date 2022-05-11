<div class="d-flex justify-content-between col-12">
    <a href="{{ route('app.manga.main', $request->manga->id) }}" class="text-light h6 text-decoration-none">{{ $request->manga->name }}</a>
    <small class="text-secondary">Requested At: {{ $request->created_at->format('Y-m-d H:i') }}</small>
</div>
@can('adminRequests', \App\Models\Request::class)
    <div class="mb-1 d-flex justify-content-between col-12">
        <small>Scanlator: &nbsp;<a href="{{ route('scan.view', $request->scanlator->id) }}" class="text-primary text-decoration-none">{{ $request->scanlator->name }}</a></small>        
        <small class="text-secondary">Answered At: {{ $request->updated_at->format('Y-m-d H:i') }}</small>
    </div>
@endcan