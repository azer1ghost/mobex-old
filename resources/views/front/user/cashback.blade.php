@extends('front.layout')

@section('content')
    <section class="section faq dash_counter_section">
        <div class="container">
            <div class="row">
                @include('front.user.sections.sidebar_menu')
                <div class="col-lg-8 col-xl-9 pr-30">
                    <div class="row">
                        <section class="packages_section full">
                            <h2 class="dahs_right_title">{{ __('additional.cashback_page.title') }}</h2>
                            <div class="cashback_list full">
                                <ul>
                                    <li>
                                        <div class="cashback_box cash_backed">
                                            <div class="col-lg-3 ">
                                                <p class="c_backed">
                                                    {{ __('additional.cashback_page.got_back') }}

                                                </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p class="c_backed_middle">
                                                    {{ __('additional.cashback_page.approved_cashback') }}
                                                   </p>
                                            </div>
                                            <div class="col-lg-3 ">
                                                <p class="cb_price">0.00 <span>AZN</span></p>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="cashback_box ">
                                            <div class="col-lg-3">
                                                <p class="c_backed">
                                                    {{ __('additional.cashback_page.waiting') }}
                                                </p>
                                            </div>
                                            <div class="col-lg-6">
                                                <p class="c_backed_middle">
                                                    {{ __('additional.cashback_page.waiting_for_days') }}
                                                </p>
                                            </div>
                                            <div class="col-lg-3 ">
                                                <p class="cb_price">0.00 <span>AZN</span></p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                                <p class="cashback_note full">
                                    {{ __('additional.cashback_page.note') }}
                                </p>
                            </div>
                            <div class="cashback_table full">
                                <h2 class="dahs_right_title">
                                    {{ __('additional.cashback_page.latest_transactions') }}
                                </h2>
                                <div class="table table--dgray">
                                    <div class="table__header">
                                        <div class="table__row">
                                            <div class="table__cell">
                                                <strong>{{ __('front.user_panel.table.title_1') }}</strong></div>
                                            <div class="table__cell">
                                                <strong>{{ __('front.user_panel.table.title_2') }}</strong></div>
                                            <div class="table__cell">
                                                <strong>{{ __('front.user_panel.table.title_3') }}</strong></div>
                                        </div>
                                    </div>
                                    <div class="table__body">
                                        @forelse($orders as $order)
                                            <div class="table__row">
                                                <div class="table__cell" data-label="Tarix">
                                                    <span><strong>{{ $order->created_at->format('M d,Y') }}</strong> {{ $order->created_at->format('h:i') }}</span>
                                                </div>
                                                <div class="table__cell" data-label="Əməliyyat">
                                                    <span>#{{ $order->custom_id }} {{ $order->note }}</span>
                                                </div>
                                                <div class="table__cell last_actions_price" data-label=" Ödənilib">
                                                    <span><strong>{{ $order->total_price . '₼'  }}</strong></span>
                                                </div>
                                            </div>
                                            @empty
                                            <div class="table__row">
                                                <div class="table__cell">
                                                    <span><strong>{{ __('additional.no_data_found') }}</strong> </span>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </section>

                        <section class="cashback_shop full">
                            <h2 class="dahs_right_title">{{ __('front.menu.shop') }}</h2>
                            <div class="row offset-30">
                                @foreach($stores as $store)
                                    @include('front.pages.shops.single_shop')
                                @endforeach
                                <div class="more_packages full" style="margin-bottom: 30px">
                                    <a class="button button--green dho" href="{{ route('shop') }}">
                                        <span>{{ __('front.user_panel.more_button') }}</span>
                                        <svg class="icon">
                                            <use xlink:href="#arrow"></use>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </section>
                        <!--cashvack shops end-->
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection