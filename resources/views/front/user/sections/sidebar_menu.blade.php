<div class="left-panel hidden-sm hidden-xs" >
    <div class="profile-box">
        <div class="upper-box">
            <div class="title-box centred">
                <div class="inner">
                    <h3>{{ auth()->user()->customer_id }}</h3>
                </div>
            </div>
        </div>
        <div class="profile-info">
            <ul class="list clearfix">
                <li>
                    <a {!! classActiveRoute('panel', 'current') !!}
                       href="{{ route('panel') }}"><i class="fas fa-columns"></i>{{ __('front.user_side_menu.unvan') }}</a>
                </li>
                <li>
                    <a {!! classActiveRoute('my-trendyol', 'current') !!}
                       href="{{ route('my-trendyol') }}"><i class="fas fa-check"></i>Trendyol təsdiq kodu
                        <span class="badge badge-pill">Yeni</span> </a>
                </li>
{{--                <li>--}}
{{--                    <a {!! classActiveRoute('filials', 'current') !!}--}}
{{--                       href="{{ route('filials') }}"><i class="fas fa-map"></i>{{ __('front.menu.filials') }}</a>--}}
{{--                </li>--}}
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
        </div>
    </div>
</div>