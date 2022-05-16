<div class="manga-block bg-dark-1 mb-4">
    <a href="{{ route('app.manga.main', $manga->id) }}" class="text-decoration-none">
        <img class="img-fluid" src="{{ asset("$manga->cover") }}">
        <div class="text-light text-center">
            {{ $manga->name }}
        </div>
    </a>
</div>