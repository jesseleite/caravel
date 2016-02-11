@if ($items->lastPage() != 1)
    <!-- Pagination -->
    <ul class="pagination">
        <li class="page-item {{ ! $items->previousPageUrl() ? 'disabled' : null }}">
            <a class="page-link" href="{{ $items->previousPageUrl() ? $items->previousPageUrl() : '#' }}" aria-label="Previous">
                <span aria-hidden="true"><i class="fa fa-angle-double-left"></i></span>
                <span class="sr-only">Previous</span>
            </a>
        </li>
        <li class="page-item">
            <p class="page-link">Page {{ $items->currentPage() }} of {{ $items->lastPage() }}</p>
        </li>
        <li class="page-item {{ ! $items->nextPageUrl() ? 'disabled' : null }}">
            <a class="page-link" href="{{ $items->nextPageUrl() ? $items->nextPageUrl() : '#' }}" aria-label="Next">
                <span aria-hidden="true"><i class="fa fa-angle-double-right"></i></span>
                <span class="sr-only">Next</span>
            </a>
        </li>
    </ul>
@endif
