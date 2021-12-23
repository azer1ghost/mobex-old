@extends('front.layout')

@section('content')
    <section class="doctors-dashboard bg-color-3">
        @include('front.user.sections.sidebar_menu')
        <div class="right-panel">
            <div class="content-container">
                <div class="outer-container">

                    <div class="declare_box add-listing full">
                        <div class="row single-box">
                            <div class="inner-box">
                                <div class="alert alert--attention alert--filled">
                                    <p class="alert__text">  {!! __('additional.courier_page.note') !!}</p>
                                </div>
                                @if($packages->count())
                                {{ Form::open(['route' => 'my-courier']) }}
                                    <div class="row">
                                        <div class="col-sm-12 form-group">
                                    <span class="form_span">
                                        {{ __('additional.courier_page.choose_package') }}
                                    </span>

                                            <div class="choose_package_dropdown full">
                                                <div class="choose_package_drop_open">
                                                    {{ __('additional.courier_page.choose_package') }}
                                                </div>
                                                <div class="choose_package_drop">
                                                    <ul class="full">
                                                        @foreach($packages as $package)
                                                            <li>
                                                                <label>
                                                                    <input data-price="{{ $package->delivery_manat_price }}"
                                                                           name="packages[{{ $package->id }}]" value="1"
                                                                           type="checkbox">
                                                                    <p>{{ $package->website_name }}
                                                                        : {{ $package->custom_id }}
                                                                        :: {{ $package->delivery_manat_price }} ₼</p>
                                                                </label>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            @include('front.form.group', ['type' => 'select', 'key' => 'city_id', 'label' => trans('front.city'), 'selects' => $cities, 'options' => ['required', 'id' => 'city', 'class' => 'form__field',  'data-route' => route('show_district_price')]])
                                        </div>
                                        <div class="col-sm-6 form-group">
                                            @include('front.form.group', ['type' => 'select', 'key' => 'district_id', 'label' => trans('front.district'), 'selects' => $districts, 'options' => ['required', 'required', 'id' => 'district', 'class' => 'form__field']])
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            @include('front.form.group', ['key' => 'full_name', 'label' => trans('additional.courier_page.person'), 'options' => ['required', 'class' => 'form__field']])
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                            @include('front.form.group', ['key' => 'phone', 'label' => trans('front.phone'), 'options' => ['required', 'class' => 'form__field']])
                                        </div>
                                        <div class="col-sm-12 form-group">
                                            @include('front.form.group', ['type' => 'textarea', 'key' => 'address', 'label' => trans('front.address'), 'options' => ['required', 'class' => 'form__field', 'rows' => 6, 'style' => 'height: 90px;']])
                                        </div>
                                        <div class="col-lg-12 col-md-6 col-sm-12 form-group">
                                            @include('front.form.group', ['type' => 'textarea', 'key' => 'note', 'label' => trans('additional.courier_page.special_notes'), 'options' => ['class' => 'form__field', 'rows' => 6, 'style' => 'height: 90px;']])
                                        </div>
                                        <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn middle_smallbtn">
                                            <button type="submit"
                                                    class="theme-btn-one">  {{ __('additional.courier_page.order') }}<i
                                                        class="icon-Arrow-Right"></i></button>
                                        </div>
                                    </div>
                               {!! Form::close() !!}
                               @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>


@endsection