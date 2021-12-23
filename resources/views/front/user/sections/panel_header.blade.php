<section class="section dash_counter_section">
    <div class="container">
        <div class="row ">
            <div class="col-12">
                <h4 class="bottom-0 top-20">{{  auth()->user()->full_name }}</h4>
                <p>{{ __('front.panel_header.user_code') }}
                    <strong>{{ auth()->user()->customer_id }}</strong>
                </p>
            </div>
        </div>
        <div class="row offset-50">
            <div class="col-md-6 col-lg-4 bottom-0">
                <div class="counter counter--filled">
                    <div class="counter__top">
                        @if (auth()->user()->package_balance)
                            <span class="counter__count">
                                {{ auth()->user()->package_balance }}
                            </span>
                        @else
                            <span class="js-counter counter__count">
                            </span>
                        @endif
                        <span class=""></span>
                    </div>
                    <div class="counter__lower"><span
                                class="counter__details">{{ __('front.panel_header.card_1.title') }}</span></div>
                    <a class="button button--white" href="{{ route('my-balance') }}">
                        <span>{{ __('front.panel_header.card_1.button') }}</span>
                        <svg class="icon">
                            <use xlink:href="#arrow"></use>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="counter counter--filled">
                    <div class="counter__top">
                        @if (auth()->user()->order_balance)
                            <span class="counter__count">
                                {{ auth()->user()->order_balance }}
                            </span>
                        @else
                            <span class="js-counter counter__count">
                            </span>
                        @endif
                        <span class=""></span>
                    </div>
                    <div class="counter__lower"><span
                                class="counter__details">{{ __('front.panel_header.card_2.title') }}</span></div>
                    <a class="button button--white" href="{{ route('my-orders.create') }}">
                        <span>{{ __('front.panel_header.card_2.button') }}</span>
                        <svg class="icon">
                            <use xlink:href="#arrow"></use>
                        </svg>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-lg-4">
                <div class="counter counter--filled">
                    <div class="counter__top">
                        @if (isset($spending) && $spending)
                            <span class="counter__count">
                                ${{ $spending['sum'] }}
                            </span>
                        @else
                            <span class="counter__count">
                                0 $
                            </span>
                        @endif
                        <span class=""></span></div>
                    <div class="counter__lower"><span
                                class="counter__details">{{ __('front.panel_header.card_3.title') }}</span></div>
                    <a class="button button--white" href="{{ route('declaration.create') }}">
                        <span>{{ __('front.panel_header.card_3.button') }}</span>
                        <svg class="icon">
                            <use xlink:href="#arrow"></use>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('css')
    <style>
        .counter__count {
            font-size: 60px;
        }

        .counter--filled {
            padding: 20px 50px 25px 50px;
        }
    </style>
@endpush