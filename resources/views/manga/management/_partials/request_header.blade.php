<div class="d-flex justify-content-between">
    <h6>{{ $request->manga->name }}</h6>
    <small class="text-secondary">Requested At: {{ $request->created_at->format('Y-m-d H:i') }}</small>
</div>