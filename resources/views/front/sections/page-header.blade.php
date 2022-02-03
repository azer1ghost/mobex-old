<div class="page-header" style="padding: 100px 0 80px;min-height: 320px; background-image: url(/front/images/bkg.jpg)">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="page-breadcrumb">
                    <ol class="breadcrumb">
                        <li><a href="{{ route('home') }}">{{ __('front.menu.home') }}</a></li>
                        <li class="active">{{ $breadTitle ?? '404' }}</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="bg-white pinside30">
                    <div class="row">
                        <div class="@if(Auth::check()) col-md-4 @else col-md-12 @endif col-sm-12">
                            @if(Auth::check())
                                <h1 class="page-title">{{ Auth::user()->full_name }}</h1>
                                <div class="sub-page-title">{{ Auth::user()->customer_id }}</div>
                            @else
                                <h1 class="page-title">{{ $title ?? __('front.page_not_found') }}</h1>
                            @endif
                        </div>
                        @if(Auth::check())
                            <div class="col-md-8 col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-md-5 col-xs-12">
                                        <div class="text-right">
                                            <a href="{{ route('my-packages', ['id' => 3]) }}?last_30_days=true">
                                                @if (isset($spending) && $spending)
                                                    <h1 class="rate-number">${{ $spending['sum'] }}
                                                        / {{ trans('front.num_orders', ['orders' => $spending['total']]) }}</h1>
                                                @else
                                                    <h1 class="rate-number">$0
                                                        / {{ trans('front.num_orders', ['orders' => 0]) }}</h1>
                                                @endif
                                            </a>
                                            <div>{{ trans('front.last_30_days') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 hidden-sm hidden-xs">
                                        <div class="text-center">
                                            <h1 class="rate-number">$0.00</h1>
                                            <div>{{ __('front.balance') }}</div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 hidden-sm hidden-xs">
                                        <div class="">
                                            <a href="#!" class="btn btn-primary">{{ __('front.enter_balance') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @if(isset($showSubButtons))
                    <div id="sub-nav-sticky-wrapper" class="sticky-wrapper">
                        <div class="sub-nav" id="sub-nav">
                            <ul class="nav nav-justified">
                                @if (isset($showSubButtons) and is_array($showSubButtons))
                                    @foreach($showSubButtons as $subButton)
                                        <li {!! classActiveRoute($subButton['route']) !!}>
                                            <a href="{{ route($subButton['route']) }}">{{ __($subButton['label']) }}</a>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>