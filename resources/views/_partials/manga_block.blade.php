<div class="manga-block bg-dark-1 mb-4">
    <a href="{{ route('app.manga.main', $manga->id) }}">
        <img class="img-fluid" src="{{ asset("$manga->cover") }}">
    </a>
</div>