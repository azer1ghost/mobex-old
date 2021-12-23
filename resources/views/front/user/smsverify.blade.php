@extends('front.layout')

@section('content')
    <!-- registration-section -->
    <section class="registration-section bg-color-3">
        <div class="pattern">
            <div class="pattern-1"
                 style="background-image: url({{ asset('assets/images/shape/shape-85.png') }});"></div>
            <div class="pattern-2"
                 style="background-image: url({{ asset('assets/images/shape/shape-86.png') }});"></div>
        </div>
        <div class="auto-container">
            <div class="inner-box">
                <div class="content-box">
                    <div class="title-box">
                        <h3>{{ __('smsverification.title') }}</h3>
                    </div>
                    <div class="inner">
                        @if($verified)
                            <div class="alert alert-success">
                                {{ __('smsverification.success') }}
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn text-center">
                                <a href="{{ route('addresses') }}"
                                   class="theme-btn-one">{{ __('smsverification.go_to_panel') }}<i
                                            class="icon-Arrow-Right"></i></a>
                            </div>
                        @else

                            @if(Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif

                            {{ Form::open(['method' => 'post', 'route' => 'checkCode', 'class' => 'registration-form']) }}
                            <div class="row clearfix">


                                <div class="col-lg-12 col-md-12 col-sm-12 form-group{{ $errors->has('sms_verification_code') ? ' has-error' : '' }}">
                                    <label class="control-label">{{ __('smsverification.code') }}</label>

                                    <input type="text" class="form__field"
                                           name="sms_verification_code">

                                    @if ($errors->has('sms_verification_code'))
                                        <label style="color: #a94442;" id="email-error"
                                               class="validation-error-label"
                                               for="sms_verification_code">{{ $errors->first('sms_verification_code') }}
                                        </label>
                                    @endif
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                    <button type="submit" class="theme-btn-one">{{ __('smsverification.submit') }}<i
                                                class="icon-Arrow-Right"></i></button>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn resend_phone_buttons">
                                    <a href="{{ route('verifyAfterEmail') }}"
                                       onclick="event.preventDefault(); document.getElementById('resend-form').submit();"
                                       class="theme-btn-one">{{ __('smsverification.resend') }}<i
                                                class="icon-Arrow-Right"></i></a>

                                    <a href="{{ route('showResendVerificationSmsForm') }}"
                                       class="theme-btn-one">{{ __('smsverification.change_number') }}<i
                                                class="icon-Arrow-Right"></i></a>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
