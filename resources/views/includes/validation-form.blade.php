@if ($errors->any())

    <ul class="errors text-warning p-0">
        @foreach ($errors->all() as $error)
            <li class="error d-flex justify-content-center">{{ $error }}</li>
        @endforeach
    </ul>

@endif