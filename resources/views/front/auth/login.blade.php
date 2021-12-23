@extends('front.layout')

@section('content')
    <!-- registration-section -->
    <section class="registration-section bg-color-3">
        <div class="pattern">
            <div class="pattern-1" style="background-image: url({{ asset('assets/images/shape/shape-85.png') }});"></div>
            <div class="pattern-2" style="background-image: url({{ asset('assets/images/shape/shape-86.png') }});"></div>
        </div>
        <div class="auto-container">
            <div class="inner-box">
                <div class="content-box">
                    <div class="title-box">
                        <h3>{!! __('auth.title') !!}</h3>
                    </div>
                    <div class="inner">
                        {!! Form::open(['method' => 'post', 'route' => 'auth.login', 'class' => 'registration-form']) !!}
                            <div class="row clearfix">

                                <div class="col-lg-12 col-md-12 col-sm-12 form-group {{ ($errors->has('login') || $errors->has('email') || $errors->has('customer_id')) ? 'has-error' : '' }}">
                                    <label>{{ __('auth.email') }}</label>
                                    <input class="form__field" id="login" type="text"
                                           name="login"
                                           value="{{ old('login') ?: (old('email') ?: old('customer_id')) }}"
                                           required
                                           autofocus/>
                                    @if ($errors->has('login') || $errors->has('email') || $errors->has('customer_id'))
                                        <label style="color: #a94442;" id="login-error" class="validation-error-label"
                                               for="login">{{ $errors->first('login') ?: ($errors->first('email') ?: $errors->first('customer_id')) }}</label>
                                    @endif
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                    <label>{{ __('auth.password') }}</label>
                                    <input class="form__field" id="password"
                                           type="password" name="password" required/>
                                    @if ($errors->has('password'))
                                        <label style="color: #a94442;" class="validation-error-label"
                                               for="password">{{ $errors->first('password') }}</label>
                                    @endif
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                    <div class="forgot-passowrd clearfix">
                                        <a href="{{ route('auth.password.email') }}">{!! __('auth.forgot_password') !!}</a>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                    <button type="submit" class="theme-btn-one">{!! __('front.menu.sign_in') !!}<i class="icon-Arrow-Right"></i></button>
                                </div>
                            </div>
                        {!! Form::close() !!}

                        <div class="login-now"><p>{!! __('auth.dont_have_an_account') !!} <a href="{{ route('register') }}">{{ __('front.menu.sign_up') }}</a></p></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- registration-section end -->

@endsection
