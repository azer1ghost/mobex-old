@if(isset($setting))
    <!-- main header -->
    <header class="main-header style-two">
        <div class="header-top">
            <!-- header-top -->
            <div class="auto-container">
                <div class="top-inner clearfix">
                    <div class="top-left pull-left mob_hide ">
                        <ul class="info clearfix">
                            <li><i class="fas fa-map-marker-alt"></i> {{ $setting->address }}</li>
                            <li><i class="fas fa-phone"></i><a
                                        href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                            </li>
{{--                            <li><i class="fab fa-whatsapp"></i><a--}}
{{--                                        href="https://api.whatsapp.com/send?phone=+994{{ App\Models\Extra\SMS::clearNumber($setting->whatsapp) }}&text=Salam Mobex komandası">{{ $setting->whatsapp }}</a>--}}
{{--                            </li>--}}
                        </ul>
                    </div>
                    <div class="top-right pull-right">
                        <ul class="info clearfix mobile_userbar_flex">
                            @if(Auth::check())
                              {{--  <li><a href="{{ route('panel') }}"> {{ auth()->user()->full_name }} ({{ auth()->user()->customer_id }})</a></li>--}}

                                <li class="language user_drop">
                                    <a href="javascript:;"> {{ auth()->user()->full_name }} ({{ auth()->user()->customer_id }})</a>

                                    <ul class="language-dropdown user_dropmenu" >
                                        <li>
                                            <a {!! classActiveRoute('panel', 'current') !!}
                                               href="{{ route('panel') }}"><i class="fas fa-columns"></i>{{ __('front.user_side_menu.unvan') }}</a>
                                        </li>
                                        <li>
                                            <a {!! classActiveRoute('my-trendyol', 'current') !!}
                                               href="{{ route('my-trendyol') }}"><i class="fas fa-check"></i>Trendyol kodu
                                                <span class="badge badge-pill" style="background-color: green">Yeni</span></a>
                                        </li>
{{--                                        <li>--}}
{{--                                            <a {!! classActiveRoute('filials', 'current') !!}--}}
{{--                                               href="{{ route('filials') }}"><i class="fas fa-map"></i>{{ __('front.menu.filials') }}</a>--}}
{{--                                        </li>--}}

                                        <li>
                                            <a {!! classActiveRoute('declaration.create', 'current') !!}
                                               href="{{ route('declaration.create') }}"><i class="fas fa-plus"></i>{{ __('front.menu.declare_button') }}</a>
                                        </li>
                                        <li>
                                            <a {!! classActiveRoute('my-packages', 'current') !!}
                                               href="{{ route('my-packages') }}"><i class="fas fa-calendar-alt"></i>{{ __('front.user_side_menu.baglama') }}</a>
                                        </li>
                                        <li>
                                            <a {!! classActiveRoute('my-orders.create', 'current') !!}
                                               href="{{ route('my-orders.create') }}">
                                                <i class="fas fa-plus-circle"></i>{{ __('front.order') }}</a>
                                        </li>
                                        <li>
                                            <a {!! classActiveRoute('my-orders', 'current') !!}
                                               href="{{ route('my-orders') }}"><i class="fas fa-clock"></i>{{ __('front.user_side_menu.sifarish') }}</a>
                                        </li>
                                        <li>
                                            <a {!! classActiveRoute('my-courier', 'current') !!}
                                               href="{{ route('my-courier') }}"><i class="fas fa-bus"></i>{{ __('front.user_side_menu.order_courier') }}</a>
                                        </li>
                                        <li>
                                            <a {!! classActiveRoute('my-couriers', 'current') !!}
                                               href="{{ route('my-couriers') }}"><i class="fas fa-th-list"></i>{{ __('front.user_side_menu.couriers') }}</a>
                                        </li>
                                        <li>
                                            <a {!! classActiveRoute('my-balance', 'current') !!}
                                               href="{{ route('my-balance') }}"><i class="fas fa-user"></i>{{ __('front.user_side_menu.balans') }}</a>
                                        </li>
                                        <li>
                                            <a {!! classActiveRoute('edit', 'current') !!}
                                               href="{{ route('edit') }}"><i class="fas fa-unlock-alt"></i>{{ __('front.user_side_menu.hesab') }}</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('auth.logout') }}"><i class="fas fa-sign-out-alt"></i>{{ __('front.logout') }}</a>
                                        </li>
                                    </ul>
                                </li>

                            @else
                                <li><a href="{{ route('login') }}">{{ __('front.menu.sign_in') }}</a></li>
                                <li><a href="{{ route('register') }}">{{ __('front.menu.sign_up') }}</a></li>
                            @endif


                            <li class="language">
                                <a href="{{ changeRouteByLang(app()->getLocale()) }}"
                                   class="active_lang">{{ substr(config('translatable.locales_name.' . app()->getLocale()), 0, 3) }}</a>
                                <ul class="language-dropdown">
                                    @foreach(config('translatable.locales_name') as $lang => $langName)
                                        @if($lang != App::getLocale())
                                            <li>
                                                <a href="{{ changeRouteByLang($lang) }}">{{ substr($langName, 0, 3) }}</a>
                                            </li>
                                        @endif
                                    @endforeach

                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- header-lower -->
        <div class="header-lower">
            <div class="auto-container">
                <div class="outer-box">
                    <div class="logo-box">
                        <figure class="logo"><a href="{{ route('home') }}"><img
                                        src="{{ $setting->header_logo ? asset('uploads/setting/' . $setting->header_logo) : asset('assets/images/logo-3.png') }}"
                                        alt="{{ env('APP_NAME') }}"></a>
                        </figure>
                    </div>
                    <div class="menu-area">
                        <!--Mobile Navigation Toggler-->
                        <div class="mobile-nav-toggler">
                            <i class="icon-bar"></i>
                            <i class="icon-bar"></i>
                            <i class="icon-bar"></i>
                        </div>
                        <nav class="main-menu navbar-expand-md navbar-light">
                            <div class="collapse navbar-collapse show clearfix" id="navbarSupportedContent">
                                <ul class="navigation clearfix">
                                    <li {{ classActiveRoute('pages.show', 'current') }}><a
                                                href="{{ route('pages.show','about') }}">{{ __('front.menu.about_us') }}</a>
                                    </li>
                                    <li><a href="{{ route('home') }}/#tariff">{{ __('front.menu.tariffs') }}</a>
                                    </li>
                                    <li {{ classActiveRoute('shop', 'current') }}><a href="{{ route('shop') }}">{{ __('front.menu.shop') }}</a>
                                    </li>
                                    <li {{ classActiveRoute('news', 'current') }}><a href="{{ route('news') }}">{{ __('front.menu.news') }}</a>
                                    </li>
{{--                                    <li {{ classActiveRoute('filials', 'current') }}><a href="{{ route('filials') }}">{{ __('front.menu.filials') }}</a>--}}
{{--                                    </li>--}}
                                    <li {{ classActiveRoute('faq', 'current') }}><a href="{{ route('faq') }}">{{ __('front.menu.faq') }}</a>
                                    </li>
                                    <li {{ classActiveRoute('contact', 'current') }}><a href="{{ route('contact') }}">{{ __('front.menu.contact_us') }}</a>
                                    </li>

                                </ul>
                            </div>
                        </nav>
                    </div>
                    <div class="btn-box"><a href="{{ route('my-orders.create') }}" class="theme-btn-one"><i
                                    class="icon-image"></i>{{ __('front.menu.order_button') }}</a></div>
                </div>
            </div>
        </div>

        <!--sticky Header-->
        <div class="sticky-header">
            <div class="auto-container">
                <div class="outer-box">
                    <div class="logo-box">
                        <figure class="logo"><a href="{{ route('home') }}">
                                <img
                                        src="{{ $setting->header_logo ? asset('uploads/setting/' . $setting->header_logo) : asset('assets/images/logo-3.png') }}"
                                        alt="{{ env('APP_NAME') }}">
                            </a></figure>
                    </div>
                    <div class="menu-area">
                        <nav class="main-menu clearfix">
                            <!--Keep This Empty / Menu will come through Javascript-->
                        </nav>
                    </div>
                    <div class="btn-box"><a href="{{ route('my-orders.create') }}" class="theme-btn-one"><i
                                    class="icon-image"></i>{{ __('front.menu.order_button') }}</a></div>
                </div>
            </div>
        </div>
    </header>
    <!-- main-header end -->
@endif