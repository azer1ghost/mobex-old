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
                        @else
                            {{ Form::open(['method' => 'post', 'route' => 'sendVerificationSms', 'class' => 'registration-form']) }}
                                <div class="row clearfix">

                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group {{ $errors->has('phone') ? ' has-error' : '' }}">
                                        <label class="validation-error-label">{{ __('smsverification.number') }}</label>

                                        <input data-inputmask="'mask': '999-999-99-99'"
                                               placeholder="050-500-00-00" id="phone" type="text"
                                               class="form__field" name="phone"
                                               value="{{ old('phone', $phone) }}"
                                               required>


                                        @if ($errors->has('phone'))
                                            <label style="color: #a94442" id="email-error" class="validation-error-label"
                                                   for="phone">{{ $errors->first('phone') }}
                                            </label>
                                        @endif
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                        <button type="submit" class="theme-btn-one">{{ __('smsverification.submit') }}<i class="icon-Arrow-Right"></i></button>
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