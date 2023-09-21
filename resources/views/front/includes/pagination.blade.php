<!-- Custom pagination links -->
<div class="row mt-8">
    <div class="col">
        <!-- nav -->
        <nav>
            <ul class="pagination">
                @if ($products->previousPageUrl())
                    <li class="page-item">
                        <a class="page-link mx-1" href="{{ $products->previousPageUrl() }}" aria-label="Previous">
                            <i class="feather-icon icon-chevron-left"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link mx-1" href="#" aria-label="Previous">
                            <i class="feather-icon icon-chevron-left"></i>
                        </a>
                    </li>
                @endif

                @foreach ($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                        <a class="page-link mx-1" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endforeach

                @if ($products->hasMorePages())
                    <li class="page-item">
                        <a class="page-link mx-1" href="{{ $products->nextPageUrl() }}" aria-label="Next">
                            <i class="feather-icon icon-chevron-right"></i>
                        </a>
                    </li>
                @else
                    <li class="page-item disabled">
                        <a class="page-link mx-1" href="#" aria-label="Next">
                            <i class="feather-icon icon-chevron-right"></i>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>
    </div>
</div>
