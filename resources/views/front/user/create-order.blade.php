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
                    <h1>{{ __('front.create_order_title') }}</h1>
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
                    <div class="declare_box non_mob_padding add-listing doctor-details-content clinic-details-content full">
                        <div class="full single-box order_forme">
                            <div class="inner-box">
                                <div class="alert alert--attention alert--filled">
                                    <p class="alert__text"> {!! __('front.create_order_alert') !!}</p>
                                </div>
                                {!! Form::open(['id'=>'order_submit_form', 'class' => 'form beyan_tertib_form order_forme_form']) !!}
                                <div class="row">
                                    <div class="form-group col-sm-6">
                                        @include('front.form.group', ['type' => 'select', 'key' => 'country', 'label' => ucfirst(strtolower(trans('front.calculator.choose_country'))), 'selects' => $countries, 'options' => ['class' => 'form__field']])
                                    </div>
                                    <div class="form-group col-sm-6">
                                        @include('front.form.group', ['key' => 'note', 'label' => trans('front.special_note'), 'options' => ['class' => 'form__field','placeholder' => trans('additional.courier_page.special_notes')]])
                                    </div>
                                </div>
                                <div id="container-url">
                                    <div class="row order_box added_order_row first-row" id="row_0">
                                        @if(session('error'))
                                            <div class="form-group col-lg-6 col-lg-offset-3">
                                                <div class="alert alert-danger">{{ __('front.enter_at_least_one_url') }}</div>
                                            </div>
                                        @endif
                                        <div class="form-group col-12">
                                            <h6 class="count-item__title"><span class="count-item__count">01</span>
                                                <span
                                                        class="order-span">{{ __('additional.order') }}</span>
                                            </h6>
                                        </div>
                                        <div class="form-group col-12 mt-4">
                                            @include('front.form.group', ['key' => 'url[0][link]', 'label' => trans('front.create_order_enter_urls'), 'options' => ['data-key' => 'link',  'data-validation' => "required url", 'class' => 'form__field', 'placeholder' => trans('front.url_example')]])
                                        </div>
                                        <div class="form-group col-sm-4">
                                            @include('front.form.group', ['key' => 'url[0][size]', 'label' => trans('front.user_orders.create_order_form.size'), 'options' => ['data-key' => 'size', 'data-validation' => "required", 'class' => 'form__field size','placeholder' => trans('additional.size_example')]])
                                        </div>
                                        <div class="form-group col-sm-4">
                                            @include('front.form.group', ['key' => 'url[0][color]', 'label' => trans('front.user_orders.create_order_form.color'), 'options' => ['data-key' => 'color', 'class' => 'form__field color','placeholder' => trans('additional.color_example')]])
                                        </div>
                                        <div class="form-group col-sm-4">
                                            @include('front.form.group', ['key' => 'url[0][note]', 'label' => trans('front.user_orders.create_order_form.special_notes'), 'options' => ['data-key' => 'note', 'class' => 'form__field', 'placeholder' => trans('front.url_note_example')]])
                                        </div>
                                        <div class="form-group col-sm-4">
                                            <span class='form_span'>{{ __('front.user_orders.create_order_form.amount') }}</span>
                                            @include('front.form.group', ['key' => 'url[0][amount]', 'options' => ['data-key' => 'amount', 'data-validation' => "required number",'type'=>'number','value' => 1, 'data-validation-allowing' => "range[1;1000]", 'class' => 'form__field order_amount', 'placeholder' => trans('additional.count_example')]])
                                        </div>
                                        <div class="form-group col-sm-4">
                                            @include('front.form.group', ['key' => 'url[0][price]', 'label' => trans('front.user_orders.create_order_form.price') . ' (TL)', 'options' => ['data-key' => 'price', 'data-validation-allowing' =>"range[0.01;1000000]  float", 'data-validation' => "required number", 'class' => 'form__field order_price','placeholder' => trans('additional.price_example')]])
                                        </div>
                                        <div class="form-group col-sm-4">
                                            @include('front.form.group', ['key' => 'url[0][cargo_fee]', 'label' => trans('front.user_orders.create_order_form.cargo_fee') . ' (TL)', 'options' => ['data-key' => 'cargo_fee', 'data-validation-allowing' =>"range[0;1000000] float",  'data-validation' => "required number", 'class' => 'form__field order_kargo_fee','placeholder' => trans('additional.cargo_price_example')]])
                                        </div>

                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn add_new_order_from">
                                            <a type="submit"
                                               class="theme-btn-one delete_new_order_button add_beyan delete_order">{{ __('front.delete') }}
                                                <i class="fas fa-times"></i></a>
                                            <a type="submit"
                                               class="theme-btn-one add_new_order_button add_beyan add_order">{{ __('front.user_orders.create_order_form.new_link') }}
                                                <i
                                                        class="fas fa-plus"></i></a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12 col-sm-12 form-group">
                                    <div class="purchase_summary appointment-section full">
                                        <div class="col-xl-6 col-lg-12 col-sm-12 right-column mobile_p0">
                                            <div class="booking-information">
                                                <div class="title-box">
                                                    <h3>Ödəniləcək</h3>
                                                </div>
                                                <div class="inner-box">
                                                    <div class="single-box">
                                                        <ul class="clearfix">

                                                            <li>{{ __('front.user_orders.create_order_form.total') }}
                                                                <span id="calc_order_price">0.00 TL</span>
                                                            </li>
                                                            <li>Komissiya: 0% (6 - 10 mart)</li>
{{--                                                            <li>{{ __('front.user_orders.create_order_form.service_fee') }}--}}
{{--                                                                <span id="cargo_fee_value">0.00 TL</span>--}}
{{--                                                            </li>--}}
{{--                                                            <li>--}}
{{--                                                                {{ __('front.user_orders.create_order_form.overall') }}--}}
{{--                                                                <span id="overall_fee"><strong></strong>0.00 TL</span>--}}
{{--                                                            </li>--}}

                                                            <li class="form-group custom-check-box mss mss_in_total mb-3">
                                                                <label class="custom-control material-checkbox">
                                                                    <input type="checkbox" class="material-control-input" checked="">
                                                                    <span class="material-control-indicator"></span>
                                                                    <a href="{{ route('pages.show','terms') }}" class="description"> {{ __('front.user_orders.create_order_form.agree') }}</a>
                                                                </label>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>
                                                <div class="btn-box">
                                                    <button type="submit" class="theme-btn-one">
                                                        {{ __('front.user_orders.create_order_form.pay_button') }}
                                                        <i class="icon-Arrow-Right"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    @include('front.lang.validation.' . app()->getLocale())
@endpush