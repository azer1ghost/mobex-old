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
            <div class="inner-box" style="max-width: 600px">
                <div class="content-box">
                    <div class="title-box">
                        <h3>{{ __('front.create_account') }}</h3>
                        <a href="{{ route('login') }}">{!! __('auth.login_to_your_account') !!}</a>
                    </div>
                    <div class="inner">
                        {!! Form::open(['method' => 'post', 'route' => 'auth.register', 'class' => 'registration-form', 'autocomplete' => 'new-password']) !!}
                        <div class="row clearfix">

                            <input type="hidden" name="referral_key" value="{{request()->get('ref')}}">

                            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                                @include('front.form.group', ['key' => 'name', 'label' => trans('front.name'), 'options' => ['class' => 'form__field']])
                            </div>

                            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 form-group {{ $errors->has('surname') ? 'has-error' : '' }}">
                                @include('front.form.group', ['key' => 'surname', 'label' => trans('front.surname'), 'options' => ['class' => 'form__field']])
                            </div>

                            <div class="col-sm-3 form-group {{ $errors->has('passport_number') ? 'has-error' : '' }}">
                                <span class="form_span">&nbsp;</span>
                                <select title="passport prefix" name="passport_prefix" id="passport_prefix"
                                        class="form__field">
                                    <option @if (old('passport_prefix') == 'AZE') selected @endif value="AZE">
                                        AZE
                                    </option>
                                    <option @if (old('passport_prefix') == 'AA') selected @endif value="AA">AA
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-4 form-group">
                                <span class="form_span" style="opacity: 0;">&nbsp;</span>
                                <input style="text-transform:uppercase"
                                       class="form__field required"
                                       placeholder="12345678" id="passport"
                                       type="text"
                                       name="passport_number"
                                       value="{{ old('passport_number')}}"
                                       required/>
                                @if ($errors->has('passport_number'))
                                    <label style="color: #a94442;" id="passport-error" class="validation-error-label"
                                           for="passport">{{ $errors->first('passport_number') }}</label>
                                @endif
                                @if ($errors->has('passport'))
                                    <label style="color: #a94442;" id="passport-error" class="validation-error-label"
                                           for="passport">{{ $errors->first('passport') }}</label>
                                @endif
                            </div>
                            <div class="col-sm-5 form-group">
                                <div data-popup="popovery" title="FIN" data-placement="top"
                                     data-html="true"
                                     data-content="<img style='width: 100%' src='{{ asset('assets/images/pass.jpg') }}'/>"
                                     class="form-group has-feedback has-feedback-left {{ $errors->has('fin') ? 'has-error' : '' }}">
                                    <span class="form_span">FİN</span>
                                    <input class="form__field required"
                                           data-inputmask="'mask': '*******'"
                                           id="fin"
                                           type="text" name="fin"
                                           value="{{ old('fin') }}"
                                           required/>
                                    @if ($errors->has('fin'))
                                        <label style="color: #a94442;" id="fin" class="validation-error-label"
                                               for="fin">{{ $errors->first('fin') }}</label>
                                    @endif
                                </div>
                            </div>


                            <div class="col-sm-6 col-lg-6 form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                                <span class="form_span">{!! __('auth.phone') !!}</span>
                                <input data-inputmask="'mask': '999-999-99-99'" placeholder="050-500-00-00" id="phone"
                                       type="text" class="form__field" name="phone"
                                       value="{{ old('phone') }}"
                                       required>
                                @if ($errors->has('phone'))
                                    <label style="color: #a94442;" id="phone-error" class="validation-error-label"
                                           for="phone">{{ $errors->first('phone') }}</label>
                                @endif
                            </div>
                            <div class="col-sm-6 form-group {{ $errors->has('gender') ? 'has-error' : '' }}">
                                <span class="form_span">&nbsp; {{ __('auth.gender') }}</span>
                                <select title="gender" name="gender" id="gender"
                                        class="form__field">
                                    <option value="0">{{ __('auth.empty') }}</option>
                                    <option @if (old('gender') == 1) selected @endif value="1">
                                        {{ __('auth.male') }}
                                    </option>
                                    <option @if (old('gender') == 2) selected @endif value="2">  {{ __('auth.female') }}
                                    </option>
                                    <option @if (old('gender') == 3) selected @endif value="3">  {{ __('auth.prefer_not_to_say') }}
                                    </option>
                                </select>
                            </div>

                            <div class="col-lg-12 form-group {{ $errors->has('promo') ? 'has-error' : '' }}">
                                @include('front.form.group', ['key' => 'promo', 'label' => 'Promo', 'options' => ['class' => 'form__field']])
                            </div>

                            <div class="col-lg-6 col-sm-12 form-group {{ $errors->has('city') ? 'has-error' : '' }}">
                                <span class="form_span">{!! __('auth.city') !!}</span>
                                <select title="city" name="city" id="city" class="form__select"
                                        data-route="{{ route('show_districts') }}">
                                    @foreach($cities as $city)
                                        <option @if (old('city') == $city->id) selected @endif value="{{ $city->id }}">
                                            {!! $city->translateOrDefault($_lang)->name !!}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('city'))
                                    <label style="color: #a94442;" id="city-error" class="validation-error-label"
                                           for="city">{{ $errors->first('city') }}</label>
                                @endif
                            </div>
                            <div class="col-lg-6 col-sm-12 form-group {{ $errors->has('district') ? 'has-error' : '' }}">
                                <span class="form_span">{!! __('auth.district') !!}</span>
                                <select title="district" name="district" id="district" class="form__select">
                                    @foreach($districts as $district)
                                        <option @if (old('district') == $district->id) selected
                                                @endif value="{{ $district->id }}">
                                            {!! $district->translateOrDefault($_lang)->name !!}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('district'))
                                    <label style="color: #a94442;" id="city-error" class="validation-error-label"
                                           for="district">{{ $errors->first('district') }}</label>
                                @endif
                            </div>

                            <div class="col-lg-12 form-group">
                                @include('front.form.group', ['type' => 'select', 'key' => 'zip_code', 'label' => "Azər Poçt filialı", 'selects' => $azerpoct_branches, 'options' => ['id' => 'filial', 'class' => 'form__field']])
                            </div>

                            <div class="col-lg-12 form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                                @include('front.form.group', ['key' => 'address', 'label' => trans('front.address'), 'options' => ['class' => 'form__field', 'rows' => 4]])
                            </div>

                            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                                @include('front.form.group', ['key' => 'email', 'label' => trans('front.email'), 'options' => ['class' => 'form__field', 'required' => 'required']])
                            </div>
                            <div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                                @include('front.form.group', ['type' => 'password', 'key' => 'password', 'label' => trans('front.password'), 'options' => [ 'class' => 'form__field']])
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn">
                                <button type="submit" class="theme-btn-one">{!! __('front.menu.sign_up') !!}<i
                                            class="icon-Arrow-Right"></i>
                                </button>
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
