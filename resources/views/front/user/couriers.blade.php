@extends('front.layout')

@section('content')
    <section class="doctors-dashboard bg-color-3">
        @include('front.user.sections.sidebar_menu')
        <div class="right-panel">
            <div class="content-container">
                <div class="outer-container">

                    <div class="declare_box add-listing full">
                        <div class="row single-box">
                            <div class="tabs-box">

                                <div class="tabs-content">
                                    <div class="tab active-tab" id="tab-1">
                                        <div class="inner-box d-flex">
                                            <div class="accordion-box mb-0">
                                                @if ( request()->has('added'))
                                                    <div class="alert alert-success"
                                                         role="alert">
                                                        Kuryer sifarişiniz növbəti gün üçün qeydə alındı. "ÖDƏ"-yə click
                                                        edərək online və ya qapıda kuryerə ödəniş edə bilərsiniz.
                                                    </div>
                                                @endif
                                                @if ( request()->has('success'))
                                                    <div class="alert alert-success"
                                                         role="alert">{{ __('front.was_paid') }}</div>
                                                @endif
                                                @if ( request()->has('error'))
                                                    <div class="alert alert-danger"
                                                         role="alert">{{ request()->get('error') }}</div>
                                                @endif

                                                <div class="title-box">
                                                    <h6>{{ __('front.user_side_menu.couriers') }}</h6>
                                                </div>
                                                @if($deliveries->count())
                                                    <ul class="accordion-inner">
                                                        <li class="accordion block">
                                                            <div class="acc-content payment_acc_content"
                                                                 style="display: block !important;">
                                                                <div class="accordion__text-block"
                                                                     style="display: block !important;">
                                                                    @foreach($deliveries as $key => $delivery)
                                                                        <div class="my_orders_orderbox">
                                                                            <div class="full-size">
                                                                                <h6 class="count-item__title"><span
                                                                                            class="count-item__count">0{{ $key + 1 }}</span>
                                                                                    <span>{{ __('additional.order') }}</span>
                                                                                </h6>
                                                                            </div>
                                                                            <ul class="list list--check list--reset">
                                                                                <li class="list__item">
                                                                                    <strong>{{ trans('front.user_orders.order_date') }}</strong> {{ $delivery->created_at->format('d/m/Y') }}
                                                                                </li>
                                                                                <li class="list__item">
                                                                                    <strong>№:</strong> {{ $delivery->custom_id }}
                                                                                </li>
                                                                                <li class="list__item">
                                                                                    <strong>{{ trans('front.total_price') }}
                                                                                        :</strong>
                                                                                    {{ $delivery->total_price }} ₼
                                                                                </li>
                                                                                <li class="list__item">
                                                                                    <strong>{{ trans('front.status') }}
                                                                                        :</strong>
                                                                                    {{ $delivery->paid ? __('front.paid') :__('front.user_orders.status_not_paid') }}
                                                                                </li>

                                                                                <li class="list__item">
                                                                                    <strong>{{ trans('front.number_items') }}
                                                                                        :</strong>
                                                                                    {{ $delivery->packages->count() }}
                                                                                </li>
                                                                                <li class="list__item">
                                                                                    <strong>{{ trans('additional.courier_page.person') }}
                                                                                        :</strong>
                                                                                    {{ $delivery->full_name }}
                                                                                </li>
                                                                                <li class="list__item">
                                                                                    <strong>{{ trans('front.phone') }}
                                                                                        :</strong>
                                                                                    {{ $delivery->cleared_phone }}
                                                                                </li>
                                                                                <li class="list__item">
                                                                                    <strong>{{ trans('front.district') }}
                                                                                        :</strong> {{ $delivery->district->translateOrDefault($_lang)->name }}
                                                                                </li>
                                                                                <li>
                                                                                    <strong>{{ trans('front.address') }}
                                                                                        :</strong>
                                                                                    {{ $delivery->address }}
                                                                                </li>
                                                                            </ul>
                                                                            <div class="full accordion_inbutton_cont">
                                                                                @if(! $delivery->status)
                                                                                    <div class="col-lg-3 col-md-4 col-sm-12 form-group message-btn accordion_inbutton">
                                                                                        <a href="{{ route('couriers.delete', $delivery->id) }}"
                                                                                           class="theme-btn-one"
                                                                                           style="background-color: #ff1c90"> {{ trans('front.delete') }}
                                                                                            <i
                                                                                                    class="icon-Arrow-down-4"></i></a>
                                                                                    </div>
                                                                                @endif
                                                                                    @if(  $delivery->total_price >= 0 )
                                                                                        {!! (new App\Models\Payments\PortManat())->generateFormForCourier($delivery) !!}
                                                                                    @endif
                                                                            </div>
                                                                        </div>
                                                                    @endforeach

                                                                </div>
                                                            </div>
                                                        </li>

                                                    </ul>
                                                @else
                                                    <div class="alert alert-warning"
                                                         role="alert">{{ __('front.no_any_package') }}</div>
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