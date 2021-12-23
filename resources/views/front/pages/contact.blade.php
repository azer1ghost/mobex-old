@extends('front.layout')

@section('content')

    <!-- information-section -->
    <section class="information-section sec-pad centred bg-color-3">
        <div class="pattern-layer">
            <div class="pattern-1"
                 style="background-image: url({{ asset('assets/images/shape/shape-88.png') }});"></div>
            <div class="pattern-2"
                 style="background-image: url({{ asset('assets/images/shape/shape-89.png') }});"></div>
        </div>
        <div class="auto-container">
            <div class="sec-title centred">
                <h2>{!! __('front.contact.title_baku') !!}</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-4 col-md-6 col-sm-12 information-column">
                    <div class="single-information-block wow fadeInUp animated animated" data-wow-delay="00ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="pattern"
                                 style="background-image: url({{ asset('assets/images/shape/shape-87.png') }});"></div>
                            <figure class="icon-box"><img src="{{ asset('assets/images/icons/icon-20.png') }}" alt="">
                            </figure>
                            <h3>{{ __('front.footer.email') }}</h3>
                            <p>
                                <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 information-column">
                    <div class="single-information-block wow fadeInUp animated animated" data-wow-delay="300ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="pattern"
                                 style="background-image: url({{ asset('assets/images/shape/shape-87.png') }});"></div>
                            <figure class="icon-box"><img src="{{ asset('assets/images/icons/icon-21.png') }}" alt="">
                            </figure>
                            <h3>{{ __('front.footer.phone') }}</h3>
                            <p>
                                <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-sm-12 information-column">
                    <div class="single-information-block wow fadeInUp animated animated" data-wow-delay="600ms"
                         data-wow-duration="1500ms">
                        <div class="inner-box">
                            <div class="pattern"
                                 style="background-image: url({{ asset('assets/images/shape/shape-87.png') }});"></div>
                            <figure class="icon-box"><img src="{{ asset('assets/images/icons/icon-22.png') }}" alt="">
                            </figure>
                            <h3>{{ __('front.footer.address') }}</h3>
                            <p>
                                {{ $setting->address }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- information-section end -->


    <!-- contact-section -->
    <section class="contact-section">
        <div class="auto-container">
            <div class="row clearfix">
                <div class="col-lg-6 col-md-12 col-sm-12 form-column">
                    <div class="form-inner">
                        <div class="sec-title"  id="success">
                            <p style="font-size: 15px">{{ __('front.contact.sub_title') }}</p>
                            <h2>{{ __('front.contact.title') }}</h2>
                        </div>
                        @if(session()->has('success'))
                            <div class="alert alert-success">{{ __('front.contact.success') }}</div>
                        @endif
                        {!! Form::open(['id' => 'contact-form', 'class' => 'default-form']) !!}
                        <div class="row clearfix">
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                @include('front.form.group', ['key' => 'c_name', 'options' => ['data-validation' => "required", 'placeholder' => trans('front.contact.name')]])
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                @include('front.form.group', ['key' => 'c_email', 'options' => ['data-validation' => "required email", 'placeholder' => trans('front.contact.email')]])
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                @include('front.form.group', ['key' => 'c_subject', 'options' => ['data-validation' => "required", 'placeholder' => trans('front.contact.subject')]])
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                @include('front.form.group', ['type' => 'textarea', 'key' => 'c_message', 'options' => ['data-validation' => "required", 'placeholder' => trans('front.contact.message')]])
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                <button class="theme-btn-one" type="submit"
                                        name="submit-form">{{ __('front.contact.submit') }}<i
                                            class="icon-Arrow-Right"></i></button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 map-column">
                    <div class="map-inner">
                        <div class="pattern"
                             style="background-image: url({{ asset('assets/images/shape/shape-90.png') }});"></div>
                        <div style="width: 100%;">
                            <iframe src="{!! $setting->contact_map !!}" width="470" height="500" frameborder="0"
                                    style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-section end -->
@endsection
@push('js')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-form-validator/2.3.26/jquery.form-validator.min.js"></script>
    @include('front.lang.validation.' . app()->getLocale())
@endpush

