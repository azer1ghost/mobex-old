<div class="col-lg-4 col-xl-3 top-50 top-lg-0">
    <div class="row">
        <div class="col-md-6 col-lg-12 bottom-50">
            <h5 class="service-details__subtitle">{!! __('front.sidebar_title') !!}</h5>
            <ul class="category-list list--reset">
                <li class="category-list__item
                {{(request()->is('p/about')) ? 'item--active' : '' }}">
                    <a class="category-list__link" href="{{ route('pages.show','about') }}">{{ __('front.menu.about_us') }}</a>
                </li>
                <li class="category-list__item
                {{(request()->routeIs('tariffs')) ? 'item--active' : '' }}">
                    <a class="category-list__link" href="{{ route('tariffs') }}">{{ __('front.menu.tariffs') }}</a>
                </li>
                <li class="category-list__item"><a class="category-list__link"
                                                   href="{{ route('services') }}">{{ __('front.menu.services') }}</a>
                </li>
                <li class="category-list__item"><a class="category-list__link"
                                                   href="{{ route('news') }}">{{ __('front.menu.news') }}</a></li>
                <li class="category-list__item"><a class="category-list__link"
                                                   href="{{ route('shop') }}">{{ __('front.menu.shop') }}</a>
                </li>
                <li class="category-list__item
                {{(request()->is('p/elite')) ? 'item--active' : '' }}">
                    <a class="category-list__link" href="{{ route('pages.show','elite') }}">{{ __('front.menu.elite') }}</a>
                </li>
                <li class="category-list__item
                {{(request()->routeIs('faq')) ? 'item--active' : '' }}">
                    <a class="category-list__link" href="{{ route('faq') }}">{{ __('front.menu.faq') }}</a>
                </li>
                <li class="category-list__item"><a class="category-list__link"
                                                   href="{{ route('contact') }}">{{ __('front.menu.contact_us') }}</a>
                </li>
            </ul>
        </div>
    </div>
</div>