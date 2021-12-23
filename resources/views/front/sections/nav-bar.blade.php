<?php if (! isset($setting)) $setting = App\Models\Setting::find(1); ?>

<div class="menu-dropdown">
    <div class="menu-dropdown__inner" data-value="start">
        <div class="screen screen--start">
            <div class="menu-dropdown__close">
                <svg class="icon">
                    <use xlink:href="#close"></use>
                </svg>
            </div>
            <div class="d-block d-lg-none bottom-20">
                <div class="screen__item"><a class="screen__link"
                                             href="{{ route('home') }}">{{ __('front.menu.home') }}</a></div>
                <div class="screen__item screen--trigger item--active" data-category="screen-one">
                    <span>{{ __('front.menu.about_us') }}</span>
                    <span>
							   <svg class="icon">
								  <use xlink:href="#chevron-right"></use>
							   </svg>
							</span>
                </div>
            </div>
            <div class="screen__item"><a class="screen__link"
                                         href="{{ route('shop') }}">{{ __('front.menu.shop') }}</a>
            </div>
            <div class="screen__item"><a class="screen__link"
                                         href="{{ route('news') }}">{{ __('front.menu.news') }}</a>
            </div>
            <div class="screen__item"><a class="screen__link" href="{{ route('faq') }}">{{ __('front.menu.faq') }}</a>
            </div>

            <div class="screen__item screen--trigger d-flex d-lg-none" data-category="screen-six">
                <span>{{ __('front.menu.languages') }}</span>
                <span>
							<svg class="icon">
							   <use xlink:href="#chevron-right"></use>
							</svg>
						 </span>
            </div>
            <div class="menu-dropdown__block top-50"><span class="block__title">{{ __('front.email') }}</span><a
                        class="screen__link"
                        href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
            </div>
            <div class="menu-dropdown__block top-20"><span class="block__title">{{ __('front.phone') }}</span>
                <a class="screen__link"
                   href="https://api.whatsapp.com/send?phone={{ $setting->phone }}&text=Salam Cfex komandası">&nbsp; {{ $setting->phone }}
                </a>
            </div>
            <div class="menu-dropdown__block">
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
            @if(Auth::check())
                <div class="menu-dropdown__block top-50"><a class="button button--filled"
                                                            href="{{ route('panel') }}">{{ __('front.user_side_menu.panel') }}</a>
                </div>
            @else
                <div class="menu-dropdown__block top-50"><a class="button button--filled"
                                                            href="{{ route('login') }}">{{ __('front.menu.sign_in') }}</a>
                </div>
            @endif
        </div>
    </div>
    <div class="menu-dropdown__inner" data-value="screen-one">
        <div class="screen screen--sub">
            <div class="screen__heading">
                <h6 class="screen__back">
                    <svg class="icon">
                        <use xlink:href="#chevron-left"></use>
                    </svg>
                    <span>{{ __('front.menu.about_us') }}</span>
                </h6>
            </div>
            <div class="screen__item"><a class="screen__link"
                                         href="{{ route('pages.show','about') }}">{{ __('front.menu.about_us') }}</a>
            </div>
            <div class="screen__item"><a class="screen__link"
                                         href="{{ route('services') }}">{{ __('front.menu.services') }}</a></div>

            <div class="screen__item"><a class="screen__link"
                                         href="{{ route('tariffs') }}">{{ __('front.menu.tariffs') }}</a></div>
            <div class="screen__item"><a class="screen__link"
                                         href="{{ route('pages.show','elite') }}">{{ __('front.menu.elite') }}</a>
            </div>
        </div>
    </div>
    <div class="menu-dropdown__inner" data-value="screen-two">
        <div class="screen screen--sub">
            <div class="screen__heading">
                <h6 class="screen__back">
                    <span>{{ __('front.menu.shop') }}</span>
                </h6>
            </div>
        </div>
    </div>

    <div class="menu-dropdown__inner" data-value="screen-six">
        <div class="screen screen--sub">
            <div class="screen__heading">
                <h6 class="screen__back">
                    <svg class="icon">
                        <use xlink:href="#chevron-left"></use>
                    </svg>
                    <span>{{ __('front.menu.languages') }}</span>
                </h6>
            </div>
            @if(count(config('translatable.locales_name')) > 1)
                @foreach(config('translatable.locales_name') as $lang => $langName)
                    <div class="screen__item @if($lang == App::getLocale()) active @endif"><a class="screen__link"
                                                                                              href="/{{ $lang }}">{{ substr($langName, 0, 3) }}</a>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
<!-- menu dropdown end-->
<!-- header start-->
<header class="page-header_6 page-header-full">
    <div class="page-header__top d-none d-xl-block">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-xl-8">
							<span>
							   <svg class="icon">
								  <use xlink:href="#pin"></use>
							   </svg>
							   {{ $setting->address }}
							</span>
                    <span>
							   <svg class="icon">
								  <use xlink:href="#"></use>
							   </svg>
							   <a href="https://api.whatsapp.com/send?phone={{ $setting->phone }}&text=Salam Cfex komandası">&nbsp; {{ $setting->phone }}</a>
							</span>
                    <span>
							   <svg class="icon">
								  <use xlink:href="#inst"></use>
							   </svg>
							   <a target="_blank"
                                  href="{{ $setting->instagram }}">{{ getInstagramName($setting->instagram) }}</a>
							</span>
                </div>
                <div class="col-xl-4 text-right">
                    <ul class="additional-menu list--reset">
                        @if(Auth::check())
                            @if(auth()->user()->verified && auth()->user()->sms_verification_status)
                                <li class="additional-menu__item">
                                    {{ __('front.panel_header.user_code') }}
                                    <a
                                            class="additional-menu__link">{{ auth()->user()->customer_id }}</a></li>
                            @else
                                <li class="additional-menu__item">
                                    <a href="{{ route('auth.logout') }}"
                                       class="additional-menu__link"> {{ __('front.logout') }}</a>
                                </li>
                            @endif
                                <li class="additional-menu__item menu_dropdown_cont">
                                    <a class="additional-menu__link" href="#">{{ auth()->user()->full_name }}</a>
                                    <div class="header_user_dropdown">
                                        <a href="{{ route('panel') }}">
                                            <img class="header-menu-img" src="{{ asset('front/images/menu/panel.png') }}" alt="#" />
                                            <p>{{ __('front.user_side_menu.panel') }}</p>
                                        </a>

                                        <a href="{{ route('addresses') }}">
                                            <img class="header-menu-img" src="{{ asset('front/images/menu/address.png') }}" alt="#" />
                                            <p>{{ __('front.user_side_menu.unvan') }}</p>
                                        </a>
                                        <a href="{{ route('my-packages') }}">
                                            <img class="header-menu-img" src="{{ asset('front/images/menu/packages.png') }}" alt="#" />
                                            <p>{{ __('front.user_side_menu.baglama') }}</p>
                                        </a>
                                        <a href="{{ route('my-orders') }}">
                                            <img class="header-menu-img" src="{{ asset('front/images/menu/orders.png') }}" alt="#" />
                                            <p>{{ __('front.user_side_menu.sifarish') }}</p>
                                        </a>
                                        <a href="{{ route('my-cashback') }}">
                                            <img class="header-menu-img" src="{{ asset('front/images/menu/cashback.png') }}" alt="#" />
                                            <p>{{ __('front.user_side_menu.cashback') }}</p>
                                        </a>
                                        <a href="{{ route('my-balance') }}">
                                            <img class="header-menu-img" src="{{ asset('front/images/menu/balance.png') }}" alt="#" />
                                            <p>{{ __('front.user_side_menu.balans') }}</p>
                                        </a>
                                        <a href="{{ route('edit') }}">
                                            <img class="header-menu-img" src="{{ asset('front/images/menu/edit.png') }}" alt="#" />
                                            <p>{{ __('front.user_side_menu.hesab') }}</p>
                                        </a>
                                        <a href="{{ route('auth.logout') }}">
                                            <img class="header-menu-img" src="{{ asset('front/images/menu/logout.png') }}" alt="#" />
                                            <p>{{ __('front.logout') }}</p>
                                        </a>
                                    </div>
                                </li>

                        @else
                            <li class="additional-menu__item"><a href="{{ route('login') }}"
                                                                 class="additional-menu__link">{{ __('front.menu.sign_in') }}</a>
                            </li>
                            <li class="additional-menu__item"><a href="{{ route('register') }}"
                                                                 class="additional-menu__link">{{ __('front.menu.sign_up') }}</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="page-header__lower">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-10 col-md-6 col-lg-2 d-flex align-items-center">
                    <div class="hamburger d-inline-block d-md-none">
                        <div class="hamburger-inner"></div>
                    </div>
                    <!-- menu-trigger end-->
                    <div class="page-header__logo">
                        <a href="{{ route('home') }}">
                            <img src="{{ $setting->header_logo ? asset('uploads/setting/' . $setting->header_logo) : asset('front/images/logo-header.png') }}"
                                 alt="logo">
                        </a>
                    </div>
                </div>
                <div class="col-8 col-lg-8 d-none d-lg-flex jusdtify-content-center">
                    <!-- main menu start-->
                    <ul class="main-menu">
                        <li class="main-menu__item {{(request()->routeIs('home')) ? 'main-menu__item--active' : '' }}">
                            <a href="{{ route('home') }}" class="main-menu__link">
                                <span>{{ __('front.menu.home') }}</span>
                            </a>
                        </li>
                        <li class="main-menu__item main-menu__item--has-child {{(request()->routeIs('pages.show')) ? 'main-menu__item--active' : '' }}">
                            <a href="{{ route('pages.show','about') }}"
                               class="main-menu__link">
                                <span>{{ __('front.menu.about_us') }}</span>
                            </a>
                            <!-- sub menu start-->
                            <ul class="main-menu__sub-list">
                                <li><a href="{{ route('services') }}"><span>{{ __('front.menu.services') }}</span></a>
                                </li>
                                <li><a href="{{ route('tariffs') }}"><span>{{ __('front.menu.tariffs') }}</span></a>
                                </li>
                                <li>
                                    <a href="{{ route('pages.show','elite') }}"><span>{{ __('front.menu.elite') }}</span></a>
                                </li>
                            </ul>
                            <!-- sub menu end-->
                        </li>
                        <li class="main-menu__item {{(request()->routeIs('shop')) ? 'main-menu__item--active' : '' }}">
                            <a href="{{ route('shop') }}" class="main-menu__link">
                                <span>{{ __('front.menu.shop') }}</span>
                            </a>

                        </li>
                        <li class="main-menu__item {{(request()->routeIs('news')) ? 'main-menu__item--active' : '' }}">
                            <a href="{{ route('news') }}" class="main-menu__link">
                                <span>{{ __('front.menu.news') }}</span>
                            </a>
                        </li>
                        <li class="main-menu__item {{(request()->routeIs('faq')) ? 'main-menu__item--active' : '' }}">
                            <a href="{{ route('faq') }}" class="main-menu__link">
                                <span>{{ __('front.menu.faq') }}</span>
                            </a>
                        </li>
                        <li class="main-menu__item {{(request()->routeIs('contact')) ? 'main-menu__item--active' : '' }}">
                            <a href="{{ route('contact') }}" class="main-menu__link">
                                <span>{{ __('front.menu.contact_us') }}</span>
                            </a>
                        </li>
                    </ul>
                    <!-- main menu end-->
                </div>
                <div class="col-2 col-md-6 col-lg-2 d-flex justify-content-end align-items-center">
                    <div class="lang-block">
                        <div class="lang-icon">
                            @if(App::getLocale() == 'az')
                                <img class="img--contain" src="{{ asset('front/img/flags/aze.svg') }}" alt="img">
                            @elseif(App::getLocale() == 'en')
                                <img class="img--contain" src="{{ asset('front/img/flags/usa.svg') }}" alt="img">
                            @elseif(App::getLocale() == 'ru')
                                <img class="img--contain" src="{{ asset('front/img/flags/rus.svg') }}" alt="img">
                            @endif
                        </div>
                        <ul class="lang-select">
                            <li class="lang-select__item lang-select__item--active">
                                <span>{{ __('front.menu.languages') }}</span>
                                <ul class="lang-select__sub-list">
                                    @if(count(config('translatable.locales_name')) > 1)
                                        @foreach(config('translatable.locales_name') as $lang => $langName)
                                            <li class="@if($lang == App::getLocale()) active @endif">
                                                <a href="{{ changeRouteByLang($lang) }}">{{ substr($langName, 0, 3) }}</a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </li>
                        </ul>
                        <!-- lang select end-->
                    </div>
                    @if(Auth::check())
                        <a class="fixed-button button button--filled header_beyan"
                           href="{{ route('declaration.create') }}">{{ __('front.menu.declare_button') }}</a>
                        <a class="fixed-button button button--filled"
                           href="{{ route('my-orders.create') }}">{{ __('front.menu.order_button') }}</a>
                    @else
                        <a class="fixed-button button button--filled"
                           href="{{ route('login') }}">{{ __('front.menu.order_button') }}</a>
                    @endif
                    <div class="hidden-md hidden-lg hidden-sm">
                        @if(auth()->check())
                            <div class="hidden-md mobile_user_drop hidden-lg hidden-sm user_for_logged" >
                                <a href="{{ route('panel') }}"> <img style="height: 26px;" src="{{ asset('front/img/user.svg') }}" /> </a>
                                <div class="header_user_dropdown">
                                    <a href="{{ route('panel') }}">
                                        <img class="header-menu-img" src="{{ asset('front/images/menu/panel.png') }}" alt="#" />
                                        <p>{{ __('front.user_side_menu.panel') }}</p>
                                    </a>

                                    <a href="{{ route('addresses') }}">
                                        <img class="header-menu-img" src="{{ asset('front/images/menu/address.png') }}" alt="#" />
                                        <p>{{ __('front.user_side_menu.unvan') }}</p>
                                    </a>
                                    <a href="{{ route('my-packages') }}">
                                        <img class="header-menu-img" src="{{ asset('front/images/menu/packages.png') }}" alt="#" />
                                        <p>{{ __('front.user_side_menu.baglama') }}</p>
                                    </a>
                                    <a href="{{ route('my-orders') }}">
                                        <img class="header-menu-img" src="{{ asset('front/images/menu/orders.png') }}" alt="#" />
                                        <p>{{ __('front.user_side_menu.sifarish') }}</p>
                                    </a>
                                    <a href="{{ route('my-cashback') }}">
                                        <img class="header-menu-img" src="{{ asset('front/images/menu/cashback.png') }}" alt="#" />
                                        <p>{{ __('front.user_side_menu.cashback') }}</p>
                                    </a>
                                    <a href="{{ route('my-balance') }}">
                                        <img class="header-menu-img" src="{{ asset('front/images/menu/balance.png') }}" alt="#" />
                                        <p>{{ __('front.user_side_menu.balans') }}</p>
                                    </a>
                                    <a href="{{ route('edit') }}">
                                        <img class="header-menu-img" src="{{ asset('front/images/menu/edit.png') }}" alt="#" />
                                        <p>{{ __('front.user_side_menu.hesab') }}</p>
                                    </a>
                                    <a href="{{ route('panel') }}/#elite">
                                        <img class="header-menu-img" src="{{ asset('front/images/menu/elite.png') }}?v=1" alt="#" />
                                        <p>{{ __('front.menu.elite') }}</p>
                                    </a>
                                    <a href="{{ route('auth.logout') }}">
                                        <img class="header-menu-img" src="{{ asset('front/images/menu/logout.png') }}" alt="#" />
                                        <p>{{ __('front.logout') }}</p>
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="hidden-md mobile_user_drop hidden-lg hidden-sm user_for_not_logged">
                                <a href="#"> <img style="height: 26px;" src="{{ asset('front/img/user.svg') }}" /> </a>
                                <div class="header_user_dropdown header_user_dropdown_not_logged">
                                    <a href="{{ route('login') }}">
                                        {{ __('front.menu.sign_in') }}
                                    </a>

                                    <a href="{{ route('register') }}">
                                        {{ __('front.menu.sign_up') }}
                                    </a>
                                </div>
                            </div>
                        @endif

                    </div>
                    <!-- menu-trigger end-->
                </div>
            </div>
        </div>
    </div>
</header>