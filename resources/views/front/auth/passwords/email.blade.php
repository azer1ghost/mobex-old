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
                        <h3>{!! __('passwords.reset_title') !!}</h3>
                    </div>
                    <div class="inner">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        {!! Form::open(['method' => 'post', 'route' => 'auth.password.email', 'class' => 'registration-form']) !!}
                        <div class="row clearfix">

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
                                <input class="form__field"
                                       id="login" type="text" name="email"
                                       value="{{ old('login') ?: (old('email') ?: old('customer_id')) }}"
                                       required autofocus/>
                                @if ($errors->has('login') || $errors->has('email') || $errors->has('customer_id'))
                                    <label style="color: #a94442;" id="login-error" class="validation-error-label"
                                           for="login">{{ $errors->first('login') ?: ($errors->first('email') ?: $errors->first('customer_id')) }}</label>
                                @endif
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                <button type="submit" class="theme-btn-one">{!! __('passwords.reset_button') !!}<i
                                            class="icon-Arrow-Right"></i></button>
                            </div>

                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- registration-section end -->
@endsection
