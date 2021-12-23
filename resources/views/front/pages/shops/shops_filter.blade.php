<div class="row bottom-30 align-items-baseline">
    <div class="col-3 col-sm-6"><span class="shop__aside-trigger">
										<svg class="icon">
											<use xlink:href="#filter"></use>
										</svg></span><span
                class="shop-results d-none d-sm-inline-block">{!! __('front.stores.overall_stores') !!} {!! $count_stores !!}</span>
    </div>
    <div class="col-9 col-sm-6 text-right">
        <!-- shop filter start-->
        <ul class="shop-filter">
            <li class="shop-filter__item shop-filter__item--active"><span>{{ __('front.stores.filter_by_country') }}</span>
                <ul class="shop-filter__sub-list">
                    @foreach($countries as $country)
                        <li class="category-list__item @if(request()->get('country') == $country->id) item--active @endif"
                            value="{{ $country->id }}">
                            <a class="category-list__link"
                               href="{{ route('shop','country='.$country->id) }}">{!! $country->translateOrDefault(app()->getLocale())->name !!}</a>
                        </li>
                    @endforeach
                </ul>
            </li>
        </ul>
        <!-- shop filter end-->
    </div>
</div>