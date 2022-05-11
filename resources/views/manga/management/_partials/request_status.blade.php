<span>
    Status: &nbsp;
    @if (isset($request->status))
        <span class="text-{{ $request->status ? 'success' : 'danger' }}">{{ $request->status ? 'Approved' : 'Rejected' }}</span>
    @else
        <span class="text-info">Pending</span>
    @endif
</span>