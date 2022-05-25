@foreach ($scans as $key => $scan)
    @if ($key % 4 == 0)
        <div class="row">
    @endif
    <div class="col-md-3">
        <div class="bg-dark-1 mb-4 p-3">
            <a href="{{ Request::routeIs('scan.all') ? route('scan.view', $scan->id) : route('app.scan.view', $scan) }}">
                <img class="img-fluid mx-auto d-block" src="{{ asset($scan->image) }}">
            </a>
            <div class="py-3">
                <div>
                    {{$scan->name}}
                </div>
                <div>
                    <small>Created At: {{Timezone::convertToLocal($scan->created_at, 'Y-m-d')}}</small>
                </div>
            </div>
        </div>
    </div>
    @if (($key + 1) % 4 == 0)
        </div>
    @endif
@endforeach

<div class="d-flex justify-content-center">
    {{ $scans->links() }}
</div>