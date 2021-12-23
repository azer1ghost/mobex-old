@if ($paginator->hasPages())
    <ul class="pagination list--reset">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="pagination__item disabled"><span>{!! __('pagination.previous') !!}</span></li>
        @else
            <li class="pagination__item pagination__item--prev"><a href="{{ $paginator->previousPageUrl() }}"
                                                                   rel="prev">{!! __('pagination.previous') !!}</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="pagination__item disabled"><span>{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="pagination__item pagination__item--active"><span>{{ $page }}</span></li>
                    @else
                        <li class="pagination__item"><a href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="pagination__item pagination__item--next"><a href="{{ $paginator->nextPageUrl() }}"
                                                                   rel="next">{!! __('pagination.next') !!}</a></li>
        @else
            <li class="pagination__item disabled"><span>{!! __('pagination.next') !!}</span></li>
        @endif
    </ul>
@endif

@push('css')
    <style>
        .pagination > li > a, .pagination > li > span {
            border: none !important;
            float: none !important;
            background-color: transparent !important;
            color: black !important;
        }

        .pagination > li:hover > a, .pagination > li:hover > span {
            color: white !important;
        }
    </style>
@endpush
