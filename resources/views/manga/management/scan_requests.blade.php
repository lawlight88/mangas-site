@extends('layouts.management')

@section('title', 'Scan Requests')

@section('content')

    @foreach ($scan->requests as $key => $request)
        @if ($key != 0)
            <hr>
        @endif
        <div>
            <div class="d-flex justify-content-between">
                <h6>{{ $request->manga->name }}</h6>
                <small class="text-secondary">Requested At: {{ $request->created_at->format('Y-m-d H:i') }}</small>
            </div>
            <div class="d-flex justify-content-between">
                <span>
                    Status: &nbsp;
                    @if (isset($request->status))
                        <span class="text-{{ $request->status ? 'success' : 'danger' }}">{{ $request->status ? 'Approved' : 'Rejected' }}</span>
                    @else
                        <span class="text-info">Pending</span>
                    @endif
                </span>
                <div>
                    <form action="#" method="post">
                        @method('delete')
                        @csrf
                        <button type="submit" class="text-light btn fa-lg d-inline-block"><i class="fa-solid fa-x"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

@endsection