@extends('front.layout')

@section('content')
    <!--page-title-two-->
    <section class="page-title-two">
        <div class="title-box centred bg-color-2">
            <div class="pattern-layer">
                <div class="pattern-1"
                     style="background-image: url({{ asset('assets/images/shape/shape-70.png') }});"></div>
                <div class="pattern-2"
                     style="background-image: url({{ asset('assets/images/shape/shape-71.png') }});"></div>
            </div>
            <div class="auto-container">
                <div class="title">
                    <h1>{{ __('additional.my_orders') }}</h1>
                </div>
            </div>
        </div>

    </section>
    <!--page-title-two end-->

    <section class="doctors-dashboard bg-color-3">
        @include('front.user.sections.sidebar_menu')
        <div class="right-panel">
            <div class="content-container">
                <div class="outer-container">
                    <div class="declare_box add-listing doctor-details-content clinic-details-content full">
                        <div class="row single-box">
                            <!-- dashboard link slider -->
                            <div class="tabs-box">
                                <div class="tab-btn-box centred">
                                    <ul class="tab-btns tab-buttons clearfix">
                                        <li @if($id == 0) class="active-btn" @endif>
                                            <a href="{{ route('my-orders', ['id' => 0]) }}">
                                                {{ __('front.user_orders.new_order') }}
                                                @if(isset($counts[0]))
                                                    <b class="text-white pl-3">[{{ $counts[0] ?? null }}]</b>
                                                @endif
                                            </a>
                                        </li>
                                        <li @if($id == 1) class="active-btn" @endif>
                                            <a href="{{ route('my-orders', ['id' => 1]) }}">
                                                {{ __('front.user_orders.paid_order') }}
                                                @if(isset($counts[1]))
                                                    <b class="text-white pl-3">[{{ $counts[1] ?? null }}]</b>
                                                @endif
                                            </a>
                                        </li>
                                        <li @if($id == 2) class="active-btn" @endif>
                                            <a href="{{ route('my-orders', ['id' => 2]) }}">
                                                {{ __('front.user_orders.ordered') }}
                                                @if(isset($counts[2]))
                                                    <b class="text-white pl-3">[{{ $counts[2] ?? null }}]</b>
                                                @endif
                                            </a>
                                        </li>
                                        <li @if($id == 3) class="active-btn" @endif>
                                            <a href="{{ route('my-orders', ['id' => 3]) }}">
                                                {{ __('front.user_orders.removed') }}
                                                @if(isset($counts[3]))
                                                    <b class="text-white pl-3">[{{ $counts[3] ?? null }}]</b>
                                                @endif
                                            </a>
                                        </li>

                                    </ul>
                                </div>
                                <div class="tabs-content">
                                    <div class="tab active-tab" id="tab-1">
                                        <div class="inner-box">
                                            <div class="accordion-box">
                                                @if (session('success'))
                                                    <div class="alert alert-success"
                                                         role="alert">{{ __('front.order_was_created') }}</div>
                                                @endif

                                                @if (session('paid'))
                                                    <div class="alert alert-success"
                                                         role="alert">{{ __('front.pay.order_was_paid') }}</div>
                                                @endif

                                                @if (session('deleted'))
                                                    <div class="alert alert-danger"
                                                         role="alert">{{ __('front.order_was_deleted') }}</div>
                                                @endif

                                                @if($orders->count())
                                                    <div class="title-box">
                                                        <h6>{{ __('additional.my_orders') }}</h6>
                                                    </div>
                                                    <ul class="accordion-inner">
                                                        @foreach($orders as $order)
                                                            <li class="accordion block">
                                                                <div class="acc-btn">
                                                                    <div class="icon-outer"></div>
                                                                    <h6> {{ $order->created_at->format('d.m.y') }} @if($order->country)
                                                                            ({{
                                                                            $order->country->translateOrDefault($_lang)->name
                                                                            }})@endif -
                                                                        № {{  $order->custom_id  }}
                                                                        :: {{ $order->total_price }} TRY</h6>
                                                                </div>
                                                                <div class="acc-content">
                                                                    <div class="accordion__text-block"
                                                                         style="display: block;">

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

                                                                            @if($order->admin_note)
                                                                                <div class="alert alert-danger">
                                                                                    {{ $order->admin_note }}
                                                                                </div>
                                                                            @endif
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
                                                                                        {{ getOnlyDomainWithExt($product->url) }}
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


                                                                        <div class="full accordion_inbutton_cont">
                                                                            @if(! $order->paid && $order->status != 3)
                                                                                <div class="col-lg-3 col-md-4 col-sm-12 form-group message-btn accordion_inbutton">
                                                                                    <a href="{{ route('payment', $order->id) }}"
                                                                                       class="theme-btn-one"> {{ __('front.user_orders.pay_button') }}
                                                                                        <i
                                                                                                class="icon-Arrow-Right"></i></a>
                                                                                </div>
                                                                            @endif
                                                                            @if(! $order->status)
                                                                                <div class="col-lg-3 col-md-4 col-sm-12 form-group message-btn accordion_inbutton">
                                                                                    {!! Form::open(['id' => 'order_' . $order->id, 'method' => 'delete', 'route' => ['my-orders.delete', $order->id]]) !!}
                                                                                    {!! Form::close() !!}
                                                                                    <a id="delete_order"
                                                                                       onclick="document.getElementById('order_<?= $order->id; ?>').submit();"
                                                                                       class="theme-btn-one"
                                                                                       style="background-color: #ff1c90; cursor: pointer"> {{ trans('front.delete') }}
                                                                                        <i
                                                                                                class="icon-Arrow-down-4"></i></a>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    @if (! session('success'))
                                                        <div class="alert alert-warning"
                                                             role="alert">{{ __('front.no_any_order') }}</div>
                                                    @endif
                                                @endif
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
