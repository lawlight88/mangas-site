<nav aria-label="page navigation">
    <ul class="pagination justify-content-center">
        <li class="page-item {{ $page->order == 1 ? 'disabled' : '' }}">
            <a class="page-link" href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter_order, 'page_order' => 1]) }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;&laquo;</span>
            </a>
        </li>
        <li class="page-item {{ $page->order - 1 > 0 ? '' : 'disabled' }}">
            <a class="page-link" href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter_order, 'page_order' => $page->order-1]) }}" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <li class="page-item"><span class="page-link">{{ $page->order }} of {{ $manga->pages_count }}</span></li>
        <li class="page-item {{ $page->order + 1 > $manga->pages_count ? 'disabled' : '' }}">
            <a class="page-link" href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter_order, 'page_order' => $page->order+1]) }}" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <li class="page-item {{ $page->order == $manga->pages_count ? 'disabled' : '' }}">
            <a class="page-link" href="{{ route('app.manga.view', ['id' => $manga->id, 'chapter_order' => $chapter_order, 'page_order' => $manga->pages_count]) }}" aria-label="Previous">
                <span aria-hidden="true">&raquo;&raquo;</span>
            </a>
        </li>
    </ul>
</nav>