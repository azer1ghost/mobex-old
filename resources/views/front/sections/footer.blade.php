@if (isset($setting))
    <footer class="page-footer"><img class="section--bg b0 r0" src="{{ asset('front/img/footer-bg.png') }}" alt="bg">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-4">
                    <h6 class="page-footer__title title--white">{{ __('front.detailed') }}</h6>
                    <ul class="page-footer__menu list--reset">
                        <li><a href="{{ route('pages.show','about') }}">{{ __('front.menu.about_us') }}</a></li>
                        <li><a href="{{ route('services') }}">{{ __('front.menu.services') }}</a></li>
                        <li><a href="{{ route('shop') }}">{{ __('front.menu.shop') }} </a></li>
{{--                        <li><a href="cashback.html">Cashback</a></li>--}}
                        <li><a href="{{ route('pages.show','elite') }}">{{ __('front.menu.elite') }}</a></li>
                        <li><a href="{{ route('news') }}">{{ __('front.menu.news') }}</a></li>
                        <li><a href="{{ route('tariffs') }}">{{{ __('front.menu.tariffs') }}}</a></li>
                        <li><a href="{{ route('pages.show','terms') }}">{{ __('front.menu.terms') }}</a></li>
                        <li><a href="{{ route('pages.show','privacy') }}">{{ __('front.menu.privacy') }}</a></li>
                        {{--@if(auth()->check())
                            <li><a href="{{ route('my-courier') }}">{{ __('front.menu.kuryer') }}</a></li>
                        @endif--}}
                        <li><a href="{{ route('faq') }}">{{ __('front.menu.faq') }}</a></li>
                        <li><a href="{{ route('contact') }}">{{ __('front.menu.contact_us') }}</a></li>
                    </ul>
                </div>
                <div class="col-md-6 col-lg-5 col-xl-4 offset-xl-1 top-40 top-md-0">
                    <h6 class="page-footer__title title--white">{{ __('front.footer.our_office') }}</h6>
                    <div class="page-footer__details">
                        <p><strong>{{ __('front.footer.address') }}</strong> <span>{{ $setting->address }}</span>
                        </p>
                        <p><strong>{{ __('front.footer.phone') }}</strong>
                            <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                        </p>
                        <p><strong>{{ __('front.footer.phone') }}</strong> <a
                                    href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                        </p>
                        <p><strong>{{ __('front.footer.working_hours') }}</strong>
                            <span>{{ $setting->working_hours }}</span></p>
                    </div>
                </div>
                <div class="col-lg-3 d-flex flex-column justify-content-between align-items-sm-center align-items-lg-end top-40 top-lg-0">
                    <div class="page-footer__logo"><a href="{{ route('home') }}"><img
                                    src="{{ $setting->footer_logo ? asset('uploads/setting/' . $setting->footer_logo) : asset('front/images/logo-footer.png') }}"
                                    alt="logo"></a></div>
                    <ul class="socials list--reset">
                        @if ($setting->facebook)
                            <li class="socials__item">
                                <a target="_blank" href="{{ $setting->facebook }}" class="socials__link">
                                    <svg class="icon">
                                        <use xlink:href="#facebook"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                        @if ($setting->twitter)
                            <li class="socials__item">
                                <a target="_blank" href="{{ $setting->twitter }}" class="socials__link">
                                    <svg class="icon">
                                        <use xlink:href="#twitter"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                        @if ($setting->linkedin)
                            <li class="socials__item">
                                <a target="_blank" href="{{ $setting->linkedin }}" class="socials__link">
                                    <svg class="icon">
                                        <use xlink:href="#linkedin"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                        @if ($setting->instagram)
                            <li class="socials__item">
                                <a target="_blank" href="{{ $setting->instagram }}" class="socials__link">
                                    <svg class="icon">
                                        <use xlink:href="#inst"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="row top-50">
                <div class="col-lg-6 text-sm-center text-lg-left">
                    <div class="page-footer__privacy"><a href="{{ route('pages.show','terms') }}">{{ __('front.menu.terms') }}</a><a
                                href="{{ route('pages.show','privacy') }}">{{ __('front.menu.privacy') }}</a><a href="{{ route('pages.show','cookies') }}">Çərəzlər</a></div>
                </div>
                <div class="col-lg-6 text-sm-center text-lg-right">
                    <div class="page-footer__copyright">
                        {{ __('front.footer.copyright') }}
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endif
