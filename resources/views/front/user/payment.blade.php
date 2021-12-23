@extends('front.layout')

@section('content')

    <section class="doctors-dashboard bg-color-3">
        @include('front.user.sections.sidebar_menu')
        <div class="right-panel">
            <div class="content-container">
                <div class="outer-container">
                    @include('front.user.sections.balances')
                    <div class="declare_box add-listing doctor-details-content clinic-details-content full">
                        <div class="row single-box">
                            <!-- dashboard link slider -->
                            <div class="tabs-box">

                                <div class="tabs-content">
                                    <div class="tab active-tab" id="tab-1">
                                        <div class="inner-box d-flex">
                                            <div class="accordion-box mb-0">
                                                <div class="title-box">
                                                    <h6> {{ $order->created_at->format('d.m.y') }} @if($order->country)
                                                            ({{
                                                            $order->country->translateOrDefault($_lang)->name
                                                            }})@endif -
                                                        № {{  $order->custom_id  }}
                                                        :: {{ $order->total_price }} TRY</h6>
                                                </div>
                                                <ul class="accordion-inner">
                                                    <li class="accordion block">
                                                        <div class="acc-content payment_acc_content"
                                                             style="display: block !important;">
                                                            <div class="accordion__text-block"
                                                                 style="display: block !important;">

                                                                <div class="my_orders_orderbox">
                                                                    <div class="full-size">
                                                                    </div>
                                                                    <ul class="list list--check list--reset">
                                                                        <li class="list__item "><strong>
                                                                                {{ __('front.user_orders.order_date') }}
                                                                            </strong>
                                                                            {{ $order->created_at->format('d.m.y h:i') }}
                                                                        </li>
                                                                        <li class="list__item"><strong>
                                                                                {{ __('front.user_orders.price') }}
                                                                            </strong>
                                                                            {{ $order->price }} TRY
                                                                        </li>
                                                                        <li class="list__item"><strong>
                                                                                {{ __('front.user_orders.country') }}
                                                                            </strong>
                                                                            {{ $order->country ? $order->country->translateOrDefault($_lang)->name : '-' }}
                                                                        </li>
                                                                        <li class="list__item"><strong>
                                                                                {{ __('front.user_orders.service_fee') }}
                                                                            </strong>
                                                                            {{ $order->service_fee }} TRY
                                                                        </li>
                                                                        <li class="list__item"><strong>
                                                                                {{ __('front.user_orders.status') }}
                                                                            </strong>
                                                                            {{ $order->getPaidInfoAttribute() }}
                                                                        </li>
                                                                        <li class="list__item"><strong>
                                                                                {{ __('front.user_orders.total_price') }}
                                                                            </strong>
                                                                            {{ $order->total_price }} TRY
                                                                        </li>
                                                                    </ul>
                                                                </div>

                                                                <h3></h3>
                                                                @foreach($order->links as $key => $product)
                                                                    <div class="my_orders_orderbox">
                                                                        <div class="full-size">
                                                                            <h6 class="count-item__title"><span
                                                                                        class="count-item__count">{{ sprintf("%02d", $key + 1) }}</span>
                                                                                <span>{{ __('additional.product') }}</span>
                                                                            </h6>
                                                                        </div>
                                                                        <ul class="list list--check list--reset">
                                                                            <li class="list__item"><strong>
                                                                                    {{ __('front.user_orders.store') }}
                                                                                </strong>
                                                                                {{ getOnlyDomain($product->url) }}
                                                                            </li>
                                                                            <li class="list__item"><strong>
                                                                                    {{ __('front.user_orders.order_count') }}
                                                                                </strong>
                                                                                {{ $product->amount }}
                                                                            </li>
                                                                            <li class="list__item"><strong>
                                                                                    {{ __('front.user_orders.color') }}
                                                                                </strong>
                                                                                {{ $product->color }}
                                                                            </li>
                                                                            <li class="list__item"><strong>
                                                                                    {{ __('front.user_orders.size') }}
                                                                                </strong>
                                                                                {{ $product->size }}
                                                                            </li>
                                                                            <li class="list__item"><strong>
                                                                                    {{ __('front.user_orders.price') }}
                                                                                </strong>
                                                                                {{ $product->price }} TRY
                                                                            </li>
                                                                            <li class="list__item"><strong>
                                                                                    {{ __('front.user_orders.cargo_price') }}
                                                                                </strong>
                                                                                {{ $product->cargo_fee }} TRY
                                                                            </li>
                                                                            <li class="list__item"><strong>
                                                                                    {{ __('front.user_orders.total_price') }}
                                                                                </strong>
                                                                                {{ $product->total_price }} TRY
                                                                            </li>
                                                                            <li class="list__item"><strong>
                                                                                    {{ __('front.user_orders.link') }}
                                                                                </strong>
                                                                                <a target="_blank"
                                                                                   href="{{ $product->url }}"> {{ str_limit($product->url, 35) }}</a>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>


                                            {!! Form::open(['id' => 'payIt', 'route' => ['my-orders.pay', $order->id]]) !!}
                                            <!--payment methods-->
                                            <div class="payment_method_section full-size">
                                                <h2 class="dahs_right_title"> {{ __('payment.payment_methods.title') }}</h2>
                                                <div class="full-size">
                                                    <div class="form__payments packages_payment">
                                                        <div class="payment_method_box ">
                                                            <label class="form__radio-label"><img
                                                                        class="form__label-img"
                                                                        src="{{ $setting->header_logo ? asset('uploads/setting/' . $setting->header_logo) : asset('assets/images/logo-3.png') }}">
                                                                @if($order->total_price <= auth()->user()->orderBalance())
                                                                    <input class="form__input-radio"
                                                                           type="radio"
                                                                           name="method" value="balance"><span
                                                                            class="form__radio-mask form__radio-mask"></span>
                                                                @endif
                                                            </label>
                                                            <p>{{ __('payment.payment_methods.method_1.title') }}</p>
                                                            <span class="payment_note">{{ __('payment.payment_methods.method_1.description') }}</span>
                                                        </div>
                                                        <div class="payment_method_box ">
                                                            <label class="form__radio-label"><img
                                                                        class="form__label-img"
                                                                        src="{{ asset('assets/images/vism.png') }}"
                                                                        alt="visa">
                                                                <input checked class="form__input-radio" type="radio"
                                                                       name="method" value="visa"><span
                                                                        class="form__radio-mask form__radio-mask"></span>
                                                            </label>
                                                            <p>{{ __('payment.payment_methods.method_2.title') }}</p>
                                                            <span class="payment_note">{{ __('payment.payment_methods.method_2.description') }}</span>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>

                                            {!! Form::close() !!}
                                            <div class="purchase_summary appointment-section payment_page_total full">
                                                <div class="col-xl-6  col-lg-12 col-md-12 col-sm-12 right-column mobile_p0">
                                                    <div class="booking-information">
                                                        <div class="title-box">
                                                            <h3>{{ __('front.user_orders.create_order_form.to_be_paid') }}</h3>
                                                        </div>
                                                        <div class="inner-box">
                                                            <div class="single-box">
                                                                <ul class="clearfix">
                                                                    <li>{{ __('front.user_orders.create_order_form.total') }}<span>{{ $order->price }} TRY</span>
                                                                    </li>
                                                                    <li>{{ __('front.user_orders.create_order_form.service_fee') }}<span>{{ $order->service_fee }} TRY</span>
                                                                    </li>
                                                                    <li>
                                                                        {{ __('front.user_orders.create_order_form.overall') }}<span><strong>{{ $order->total_price }} TRY</strong></span>
                                                                    </li>
                                                                    <li class="form-group custom-check-box mss mss_in_total">
                                                                        <label class="custom-control material-checkbox mb-4">
                                                                            <input type="checkbox"
                                                                                   class="material-control-input"
                                                                                   checked="">
                                                                            <span class="material-control-indicator"></span>
                                                                            <span class="description">{{ __('front.user_orders.create_order_form.agree') }}</span>
                                                                        </label>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                        </div>
                                                        <div class="btn-box">
                                                            <button type="submit" onclick="document.getElementById('payIt').submit();" class="theme-btn-one">{{ __('front.user_orders.create_order_form.pay_button') }}<i class="icon-Arrow-Right"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        </div>

    </section>

@endsection