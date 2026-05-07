@if ($paginator->hasPages())
    <ul class="pagination justify-content-center" style="gap: 0.2rem; margin: 0;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span class="page-link" style="padding: 0.2rem 0.5rem; font-size: 0.7rem;">«</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" style="padding: 0.2rem 0.5rem; font-size: 0.7rem;">«</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span class="page-link" style="padding: 0.2rem 0.5rem; font-size: 0.7rem;">{{ $element }}</span></li>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active" aria-current="page"><span class="page-link" style="padding: 0.2rem 0.5rem; font-size: 0.7rem;">{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}" style="padding: 0.2rem 0.5rem; font-size: 0.7rem;">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" style="padding: 0.2rem 0.5rem; font-size: 0.7rem;">»</a></li>
        @else
            <li class="page-item disabled"><span class="page-link" style="padding: 0.2rem 0.5rem; font-size: 0.7rem;">»</span></li>
        @endif
    </ul>
@endif   