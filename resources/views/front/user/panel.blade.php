@extends('front.layout')

@section('content')
    @include('front.user.sections.panel_header')
    <section class="section faq dahboard_main_section">
        <div class="container">
            <div class="row">
                @include('front.user.sections.sidebar_menu')
                <div class="col-lg-8 col-xl-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="elite_right_box elite_left">
                                <img src="{{ $setting->header_logo ? asset('uploads/setting/' . $setting->header_logo) : asset('front/images/logo-header.png') }}"
                                     alt="logo">
                                <p>{{ __('front.user_panel.left_card.text') }}</p>
                                <a href="{{ route('pages.show','elite') }}" style="color: white" class="button button--account"
                                   type="submit">
                                    <span>{{ __('front.user_panel.left_card.button') }}</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="elite_right_box elite_right">
                                <div class="elite_right_handle_cont full">
                                    <div class="elite_handle full">
                                       <span class="eloite_handle_progress" style="width:{{ ($total > 100 ? 100 : $total) }}%;" data-txt="{{ $total }}">
                                       <i></i>
                                       </span>
                                    </div>
                                    <img src="{{ asset('front/img/star.svg') }}" class="elite_right_vip" alt="">
                                </div>
                                <p>{{ __('front.user_panel.right_card.text') }}</p>
                            </div>
                        </div>
                        <div class="col-md-12 elite_last_actions">
                            <h5 class="bottom-30">{{ __('front.user_panel.latest_transactions') }}</h5>
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
                                            <div class="table__cell" data-label="{{ __('front.user_panel.table.title_1') }}">
                                                <span><strong>{{ $order->created_at->format('M d,Y') }}</strong> {{ $order->created_at->format('h:i') }}</span>
                                            </div>
                                            <div class="table__cell" data-label="{{ __('front.user_panel.table.title_2') }}">
                                                <span>#{{ $order->custom_id }}</span>
                                            </div>
                                            <div class="table__cell last_actions_price" data-label="{{ __('front.user_panel.table.title_3') }}">
                                                <span><strong>{{ $order->total_price }} ₺</strong></span>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="table__row">

                                            <div class="table__cell"></div>
                                            <div class="table__cell">
                                                <span><strong>{{ __('additional.no_data_found') }}</strong> </span>
                                            </div>
                                            <div class="table__cell"></div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                    {!! $orders->render() !!}
                </div>
            </div>
        </div>
    </section>
@endsection
