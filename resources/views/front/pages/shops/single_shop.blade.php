<div class="col-sm-6 col-xl-4">
    <div class="shop-item text-center">
        @if($store->featured)
            <div class="shop-item__badge badge--sale">{!! __('front.stores.featured') !!}</div>
        @endif
        <div class="shop-item__img"><img class="img--contain" src="{{ asset($store->logo) }}" alt="img"/></div>
        <h6 class="shop-item__title"><a href="{{ $store->url }}">{!! $store->name !!}</a></h6>
        <div class="shop-item__price">
{{--            <span>{!! $store->cashback_percent !!}{!! __('front.stores.cashback') !!}</span>--}}
        </div>
        <ul class="rating-list justify-content-center">
            <li class="rating-list__item">
                <svg class="icon">
                    <use xlink:href="#star"></use>
                </svg>
            </li>
            <li class="rating-list__item">
                <svg class="icon">
                    <use xlink:href="#star"></use>
                </svg>
            </li>
            <li class="rating-list__item">
                <svg class="icon">
                    <use xlink:href="#star"></use>
                </svg>
            </li>
            <li class="rating-list__item">
                <svg class="icon">
                    <use xlink:href="#star"></use>
                </svg>
            </li>
            <li class="rating-list__item">
                <svg class="icon">
                    <use xlink:href="#star"></use>
                </svg>
            </li>
        </ul>
        <a class="button button--green" target="_blank" href="{{ $store->cashback_link }}"><span>{!! __('front.stores.to_website') !!}</span>
            <svg class="icon">
                <use xlink:href="#bag"></use>
            </svg>
        </a>
    </div>
</div>