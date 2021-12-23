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
                        <h3>{{ __('emailverification::messages.resend.title') }}</h3>
                    </div>
                    <div class="inner">


                        @if($verified)
                            <div style="margin-top: 20px; margin-bottom: 20px" class="alert alert-success">
                                {{ __('emailverification::messages.done') }}
                            </div>
                            @if(env('SMS_VERIFY'))
                                <div class="alert alert-danger">
                                    {{ __('smsverification.sms_verification_info') }}
                                </div>

                                {{ Form::open(['method' => 'post', 'route' => 'verifyAfterEmail']) }}
                                <input type="hidden" class="form__field" name="phone"
                                       value="{{ Auth::user()->phone }}">

                                <div align="right" style=" margin-top: 30px; margin-right: 30px">
                                    <button type="submit"
                                            class="theme-btn-one">{{ __('smsverification.send') }}</button>
                                </div>

                                {{ Form::close() }}
                            @else
                                <a href="{{ route('showResendVerificationSmsForm') }}"
                                   class="theme-btn-one">{{ __('smsverification.title') }}<i
                                            class="icon-Arrow-Right"></i></a>

                            @endif
                        @else

                            {{ Form::open(['method' => 'post', 'route' => 'resendVerificationEmail', 'class' => "registration-form" ]) }}
                            <div class="row clearfix">
                                <div class="col-lg-12 cool-md-12">
                                    <div class="alert alert--attention alert--filled ">
                                        <p class="alert__text"> {!! __('emailverification::messages.resend.warning', ['email' => $email]) !!}</p>
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12">
                                    <p class="confrim_note">{{ __('emailverification::messages.resend.instructions') }}</p>
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="validation-error-label">{{ __('emailverification::messages.resend.email') }}</label>

                                    <input type="text" class="form__field" name="email"
                                           value="{{ old('email', $email) }}">

                                    @if ($errors->has('email'))
                                        <label style="color: #a94442" id="email-error"
                                               class="validation-error-label"
                                               for="email">{{ $errors->first('email') }} }}
                                        </label>
                                    @endif
                                </div>

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                    <button type="submit" name="Submit"
                                            class="theme-btn-one">{{ __('emailverification::messages.resend.submit') }}
                                        <i class="icon-Arrow-Right"></i></button>
                                </div>
                            </div>
                            {!! Form::close() !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- registration-section end -->
@endsection
