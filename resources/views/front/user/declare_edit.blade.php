@extends('front.layout')

@section('content')
    <section class="section faq dash_counter_section">
        <div class="container">
            <div class="row">
                @include('front.user.sections.sidebar_menu')
                <div class="col-lg-8 col-xl-9 pr-30">
                    <div class="row">
                        <h5 class="service-details__subtitle">Bəyannamənin tərtibi</h5>
                        {{ Form::open(['class' => 'beyan_tertib_form', 'files' => true]) }}
                        <div class="row">
                            <div class="col-sm-6">
                                @include('front.form.group', ['type' => 'select', 'key' => 'country_id', 'label' => trans('front.warehouse'), 'selects' => $countries, 'options' => ['class' => 'form__field']])
                            </div>
                            <div class="col-sm-6">
                                @include('front.form.group', ['key' => 'website_name', 'label' => trans('front.website_name'), 'options' => ['class' => 'form__field', 'placeholder' => trans('front.website_example'), 'data-validation' => 'required']])
                            </div>
                            <div class="col-sm-6">
                                @include('front.form.group', ['key' => 'tracking_code', 'label' => trans('front.tracking_code'), 'options' => ['class' => 'form__field', 'data-validation' => 'required length custom', 'data-validation-length' => "min9", 'data-validation-regexp' => "^[A-Za-z0-9-]+$"]])
                            </div>
                            <div class="col-sm-6">
                                @include('front.form.group', ['type' => 'select', 'key' => 'type_id', 'label' => trans('front.product_category'), 'selects' => $categories, 'options' => ['id' => 'type_id', 'data-validation' => "required", 'class' => 'form__field select']])
                            </div>
                            <div class="col-sm-4">
                                @include('front.form.group', ['key' => 'number_items', 'label' => trans('front.number_items'), 'options' => ['class' => 'form__field', 'data-validation' => 'required number', 'data-validation-allowing' => "range[1;10000]"]])
                            </div>
                            <div class="col-sm-4">
                                @include('front.form.group', ['key' => 'shipping_amount', 'label' => trans('front.shipping_amount'), 'options' => ['class' => 'form__field', 'data-validation' => 'required number', 'data-validation-allowing' => "float"]])
                            </div>
                            <div class="col-sm-4">
                                @include('front.form.group', ['type' => 'select', 'key' => 'shipping_amount_cur', 'label' => trans('front.shipping_amount_cur'), 'selects' => config('ase.attributes.currencies'), 'options' => ['class' => 'form__field']])
                            </div>
                            <div class="col-sm-12">
                                <span class="form_span">{{ __('front.invoice') }}</span>
                                <input class="form__field file_upload_input" type="file"
                                       name="invoice"
                                       data-validation="required mime size"
                                       data-validation-allowing="jpg, png, pdf, doc, docx, jpeg"
                                       data-validation-max-size="3M"
                                       placeholder="İnvoys yüklə"/>
                                @if ($errors->has('invoice'))
                                    <span class="help-block">
                                          <strong>{!! $errors->first('invoice') !!}</strong>
                                     </span>
                                @endif
                            </div>
                            <div class="col-sm-12">
                                @include('front.form.group', ['type' => 'textarea', 'key' => 'user_comment', 'label' => trans('front.note'), 'options' => ['rows' => 3, 'class' => 'form-control']])
                            </div>
                            <div class="col-sm-6 col-md-8">
                                <label class="form__checkbox-label  bottom-20"><span class="form__label-text">Tərkibində maye var</span>
                                    <input class="form__input-checkbox" type="checkbox" name="size-select"
                                           value="Size S"/><span class="form__checkbox-mask"></span>
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-4 text-lg-right">
                                <button class="button button--green" type="submit">
                                    <span>{{ __('front.save') }}</span>
                                    <svg class="icon">
                                        <use xlink:href="#arrow"></use>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('css')
    <style>
        .form__field {
            background-color: white;
        }
    </style>
@endpush