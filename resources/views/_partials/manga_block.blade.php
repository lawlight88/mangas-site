<?php if(isset($favorite)) $manga = $favorite->manga ?>
<?php if(isset($manga_like_this)) $manga = $manga_like_this ?>
<div class="d-inline-block">
    <div class="manga-block bg-dark-1 {{ Route::currentRouteName() == 'user.profile' ? null : 'mb-4' }}">
        <a href="{{ route('app.manga.main', $manga->id) }}" class="text-decoration-none">
            <img class="img-fluid mx-auto d-block" src="{{ asset('storage/'."$manga->cover") }}">
            <div class="text-light text-center">
                {{ $manga->name }}
            </div>
        </a>
    </div>
</div>