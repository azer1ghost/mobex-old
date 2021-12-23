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
                        <h3> {{ trans('passwords.reset_title') }}</h3>
                    </div>
                    <div class="inner">
                        {{ Form::open(['method' => 'post', 'route' => 'auth.password.reset', 'class' => 'registration-form' ]) }}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="row clearfix">
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group {{ ($errors->has('login') || $errors->has('email') || $errors->has('customer_id')) ? 'has-error' : '' }}">
                                <input placeholder="{{ __('passwords.email') }}" id="login" type="text" class="form-control"
                                       name="email"
                                       value="{{ old('login') ?: (old('email') ?: old('customer_id')) }}"
                                       required
                                       autofocus>
                                @if ($errors->has('login') || $errors->has('email') || $errors->has('customer_id'))
                                    <label id="login-error" class="validation-error-label"
                                           for="login">{{ $errors->first('login') ?: ($errors->first('email') ?: $errors->first('customer_id')) }}</label>
                                @endif
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 form-group {{ ($errors->has('password')) ? 'has-error' : '' }}">
                                <input placeholder="{{ __('auth.password') }}" id="password" type="password"
                                       class="form-control"
                                       name="password" required>
                                @if ($errors->has('password'))
                                    <label id="login-error" class="validation-error-label"
                                           for="login">{{ $errors->first('password') }}</label>
                                @endif
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group {{ ($errors->has('password_confirmation')) ? 'has-error' : '' }}">
                                <input placeholder="{{ __('passwords.confirm_password') }}" id="password_confirmation"
                                       type="password" class="form-control"
                                       name="password_confirmation" required>
                                @if ($errors->has('password_confirmation'))
                                    <label id="password_confirmation-error" class="validation-error-label"
                                           for="password_confirmation">{{ $errors->first('password_confirmation') }}</label>
                                @endif
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                <button type="submit" class="theme-btn-one">{{ __('passwords.submit') }}<i
                                            class="icon-Arrow-Right"></i></button>
                            </div>
                        </div>
                        {{ Form::close() }}

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection