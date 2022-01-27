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
                    <h1>{{ __('additional.declaration') }}</h1>
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
                    <div class="declare_box add-listing full">
                        <div class="row single-box">
                            <!-- dashboard link slider -->
                            <div class="inner-box">
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert">
                                        Bu bağlamanı bizim sistemdə yenidən bəyan etməyə ehtiyac yoxdur. Əksinə <b>SmartCustoms tətbiqi</b> və ya web portalı olan (<a href="https://customs.gov.az">customs.gov.az</a>) vasitəsiylə gömrük sistemində bəyan etməyiniz tövsiyyə edilir. Əgər SmartCustoms sistemi xəta verərsə bunu görməzdən gələ bilərsiniz və bununla bağlı bizə müraciət etmək lazım deyil. Bağlamanız problemsiz sizə ən qısa zamanda çatdırılacaqdır.
                                    </div>
                                @endif
                                {{ Form::open(['class' => 'beyan_tertib_form', 'files' => true]) }}
                                <div class="row clearfix">
                                    <div class="form-group col-lg-6">
                                        <label for="country_id">@lang('front.warehouse')</label>
                                        <select name="country_id"  class="form-control form__field" id="country_id">
                                            @foreach($countries as $id => $country)
                                                <option @if(isset($item) && $item->warehouse->country_id === $id) selected @endif value="{{$id}}">{{$country}}</option>
                                            @endforeach
                                        </select>
{{--                                    @include('front.form.group', ['type' => 'select', 'key' => 'country_id', 'label' => trans('front.warehouse'), 'selects' => $countries, 'options' => ['class' => 'form__field']])--}}
                                    </div>
                                    <div class="form-group col-lg-6">
                                        @include('front.form.group', ['key' => 'website_name', 'label' => trans('front.create_order_enter_urls'), 'options' => ['class' => 'form__field', 'placeholder' => trans('front.website_example'), 'data-validation' => 'required']])
                                    </div>
                                    <div class="form-group col-lg-12">
                                        @include('front.form.group', ['key' => 'tracking_code', 'label' => trans('front.tracking_code'), 'options' => ['class' => 'form__field', 'data-validation' => 'required length custom', 'data-validation-length' => "min9", 'data-validation-regexp' => "^[A-Za-z0-9-]+$"]])
                                    </div>
                                    <div class="form-group col-lg-4">
                                        @include('front.form.group', ['type' => 'select', 'key' => 'type_id', 'label' => trans('front.product_category'), 'selects' => $categories, 'options' => ['id' => 'type_id', 'data-validation' => "required", 'class' => 'form__field select']])
                                    </div>
                                    <div class="form-group col-lg-2">
                                        @include('front.form.group', ['key' => 'number_items', 'label' => trans('front.number_items'), 'options' => ['class' => 'form__field', 'data-validation' => 'required number', 'data-validation-allowing' => "range[1;10000]"]])
                                    </div>
                                    <div class="form-group col-lg-3">
                                        @include('front.form.group', ['key' => 'shipping_amount', 'label' => trans('front.shipping_amount'), 'options' => ['class' => 'form__field', 'data-validation' => 'required number', 'data-validation-allowing' => "float"]])
                                    </div>
                                    <div class="form-group col-lg-3">
                                        @include('front.form.group', ['type' => 'select', 'key' => 'shipping_amount_cur', 'label' => trans('front.shipping_amount_cur'), 'selects' => config('ase.attributes.currencies'), 'options' => ['class' => 'form__field']])
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <span class="form_span">{{ __('front.invoice') }}</span>
                                        <div class="upload_invoice">
                                            <input @if(! isset($item)) required
                                                   @endif class="form__field file_upload_input" type="file"
                                                   name="invoice"
                                                   data-validation="@if(! isset($item)) required @endif mime size"
                                                   data-validation-allowing="jpg, png, pdf, doc, docx, jpeg"
                                                   data-validation-max-size="3M"
                                                   placeholder="İnvoys yüklə"/>
                                        </div>
                                        <span class="help-block">
                                            Məhsulu sifariş etdiyiniz saytın müvafiq bölümündəki məhsul və qiymət düşən <b>hissənin ekran şəklini</b> bu xanaya yükləyin!
                                        </span>
                                        @if ($errors->has('invoice'))
                                        <span class="help-block">
                                            <strong>{!! $errors->first('invoice') !!}</strong>
                                        </span>
                                        @endif
                                        @if(isset($item))
                                            @if($item->getOriginal('invoice'))
                                                <a target="_blank" href="{{ $item->invoice }}">Yüklü olan invoysa bax</a>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-6">
                                        @include('front.form.group', ['key' => 'user_comment', 'label' => trans('front.note'), 'options' => ['rows' => 3, 'class' => 'form__field']])
                                    </div>
{{--                                    <div class="form-group col-lg-6 col-md-8 custom-check-box">--}}
{{--                                        <label class="custom-control material-checkbox ">--}}
{{--                                            <input type="checkbox" name="has_liquid" class="material-control-input">--}}
{{--                                            <span class="material-control-indicator"></span>--}}
{{--                                            <span class="description">{{ __('front.contains_liquid') }}</span>--}}
{{--                                        </label>--}}
{{--                                    </div>--}}
                                    <div class="form-group col-12 custom-check-box">
                                        <label class="custom-control material-checkbox  @if($errors->has('i_agree')) is-invalid @endif">
                                            <input type="checkbox" name="i_agree"  checked class="material-control-input" value="1">
                                            <span class="material-control-indicator"></span>
                                            <span class="description">
                                                <a href="{{ route('pages.show','terms') }}" class="description"> {{ __('front.user_orders.create_order_form.agree') }}</a>
                                            </span>
                                        </label>
                                        <span class="invalid-feedback" role="alert">
                                            <strong>Bu xana mütləq seçilməlidir</strong>
                                        </span>
                                    </div>
                                    <div class="form-group col-lg-12 col-md-4 text-lg-right">
                                        <div class="col-lg-12 col-md-12 col-lg-12 form-group message-btn middle_smallbtn">
                                            <button type="submit" class="theme-btn-one">{{ __('front.save') }}<i
                                                        class="icon-Arrow-Right"></i></button>
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

@if(isset($item))
    @push('js')
        @if($item->status == 0)
            <script>
                $("[name='country_id']").prop( "disabled", true ).addClass('disabled');
                $("[name='tracking_code']").prop( "disabled", true );
            </script>
        @endif
    @endpush
@endif