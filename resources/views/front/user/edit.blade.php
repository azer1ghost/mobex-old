@extends('front.layout')

@section('content')

    <!--page-title-two-->
    <section class="page-title-two">
        <div class="title-box centred bg-color-2">
            <div class="pattern-layer">
                <div class="pattern-1"
                     style="background-image: url({{ asset('assets/images/shape/shape-70.png') }});"></div>
                <div class="pattern-2"
                     style="background-image: url({{ asset('assets/images/shape/shape-71.png') }});"></div>
            </div>
            <div class="auto-container">
                <div class="title">
                    <h1>{{ __('front.editing_member_profile') }}</h1>
                </div>
            </div>
        </div>

    </section>
    <!--page-title-two end-->

    <section class="doctors-dashboard bg-color-3">
        @include('front.user.sections.sidebar_menu')
        <div class="right-panel">
            <div class="content-container">
                <div class="outer-container">
                    <div class="declare_box add-listing full">
                        <div class="row single-box">
                            <!-- dashboard link slider -->
                            <div class="inner-box">
                                {{ Form::open(['route' => 'update']) }}
                                <div class="row">
                                    <div class="col-12 form-group form-group">
                                        @include('front.form.group', ['key' => 'email', 'label' => trans('front.email'), 'options' => ['class' => 'form__field', 'disabled' => 'disabled']])
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        @include('front.form.group', ['key' => 'name', 'label' => trans('front.name'), 'options' => ['class' => 'form__field']])
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        @include('front.form.group', ['key' => 'surname', 'label' => trans('front.surname'), 'options' => ['class' => 'form__field']])
                                    </div>
                                    <div class="col-sm-3 col-6 form-group">
                                        <span class="form_span">Seriya</span>
                                        <select title="passport prefix" name="passport_prefix" id="passport_prefix"
                                                class="form__select">
                                            <option @if (old('passport_prefix', $item->pre_passport) == 'AZE') selected
                                                    @endif value="AZE">
                                                AZE
                                            </option>
                                            <option @if (old('passport_prefix', $item->pre_passport) == 'AA') selected
                                                    @endif value="AA">AA
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3 col-6 form-group">
                                        <span class="form_span" style="opacity: 0;">&nbsp;</span>
                                        <input style="text-transform:uppercase"
                                               class="form__field required"
                                               placeholder="12345678" id="passport"
                                               type="text"
                                               name="passport_number"
                                               value="{{ old('passport_number', $item->pos_passport) }}"
                                               required/>
                                        @if ($errors->has('passport_number'))
                                            <label style="color: #a94442;" id="passport-error"
                                                   class="validation-error-label"
                                                   for="passport">{{ $errors->first('passport_number') }}</label>
                                        @endif
                                        @if ($errors->has('passport'))
                                            <label style="color: #a94442;" id="passport-error"
                                                   class="validation-error-label"
                                                   for="passport">{{ $errors->first('passport') }}</label>
                                        @endif
                                    </div>

                                    <div class="col-sm-6 form-group">
                                        <span class="form_span">FİN</span>
                                        <input class="form__field required"
                                               data-inputmask="'mask': '*******'"
                                               placeholder="FİN"
                                               id="fin"
                                               type="text" name="fin"
                                               value="{{ old('fin', $item->fin) }}"
                                               required/>
                                        @if ($errors->has('fin'))
                                            <label style="color: #a94442;" id="phone-error"
                                                   class="validation-error-label"
                                                   for="fin">{{ $errors->first('fin') }}</label>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        @include('front.form.group', ['key' => 'birthday', 'label' => trans('front.birthday'), 'options' => ['min' => "1950-01-01", 'max' => "2002-01-01", 'class' => 'form__field changeTypeToDate']])
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        @include('front.form.group', ['key' => 'phone', 'label' => trans('front.phone'), 'options' => ['class' => 'form__field', 'data-inputmask' => "'mask': '999-999-99-99'", 'placeholder' => "050-500-00-00"]])
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        @include('front.form.group', ['type' => 'select', 'key' => 'city_id', 'label' => trans('front.city'), 'selects' => $cities, 'options' => ['id' => 'city', 'class' => 'form__field',  'data-route' => route('show_districts')]])
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        @include('front.form.group', ['type' => 'select', 'key' => 'district_id', 'label' => trans('front.district'), 'selects' => $districts, 'options' => ['id' => 'district', 'class' => 'form__field']])
                                    </div>

                                    <div class="col-12 p-0 mb-4">
                                        @if(!$hasInBaku)
                                            <div class="col-12 my-2">
                                                @include('front.form.group', ['type' => 'select', 'key' => 'filial_id', 'label' => trans('auth.filial'), 'selects' => $filials, 'options' => ['id' => 'filial', 'class' => 'form__field']])
                                            </div>
{{--                                            <div class="col-12 p-0 my-4" x-data="dataStorage"--}}
{{--                                                 x-init="$watch('sent_to', value => showArea(value))">--}}
{{--                                                <div class="col-12 orm-group mt-2">--}}
{{--                                                    <div class="form-check mx-2">--}}
{{--                                                        <input class="form-check-input" x-model="sent_to" name="sent_to"--}}
{{--                                                               type="radio" id="filialRadio" value="filial"--}}
{{--                                                               @if(is_null($item->branch_id)) checked @endif>--}}
{{--                                                        <label class="form-check-label" for="filialRadio">--}}
{{--                                                            Bağlamaları Filiala göndər--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                    <div class="form-check mx-2">--}}
{{--                                                        <input class="form-check-input" x-model="sent_to" name="sent_to"--}}
{{--                                                               type="radio" id="branchRadio" value="branch"--}}
{{--                                                               @if(is_numeric($item->branch_id)) checked @endif>--}}
{{--                                                        <label class="form-check-label" for="branchRadio">--}}
{{--                                                            Bağlamaları Məntəqəyə göndər--}}
{{--                                                        </label>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                                <div x-show="!hasBranch" class="col-12 my-2">--}}
{{--                                                    @include('front.form.group', ['type' => 'select', 'key' => 'filial_id', 'label' => trans('auth.filial'), 'selects' => $filials, 'options' => ['id' => 'filial', 'class' => 'form__field']])--}}
{{--                                                </div>--}}
{{--                                                <div x-show="hasBranch" class="col-12 my-2">--}}
{{--                                                    <div class="col-sm-12 p-0">--}}
{{--                                                        @include('front.form.group', ['type' => 'select', 'key' => 'branch_id',  'label' => trans('auth.branch'),  'selects' => $branches, 'options' => ['id' => 'branch', 'class' => 'form__field col-sm-12']])--}}
{{--                                                    </div>--}}
{{--                                                    <div class="col-sm-12">--}}
{{--                                                        <small class="text-danger ">Diqqət! - məntəqəyə göndərilən bağlamalara--}}
{{--                                                            əlavə tarif tətbiq olunur</small>--}}
{{--                                                    </div>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
                                        @else
                                            <div class="col-12 form-group">
                                                <span class="form_span">@lang('auth.filial')</span>
                                                <input
                                                   class="form-control"
                                                   type="text"
                                                   readonly
                                                   value="Diqqət hörmətli istifadəçi yolda olan bağlamanız əvvəlcədən seçdiyiniz ünvana göndəriləcək"
                                                >
                                            </div>
{{--                                            <span>--}}
{{--                                                 Hazırda seçili olan:--}}
{{--                                                 @if(is_numeric($item->branch_id))--}}
{{--                                                    {{$item->branch->name}} (Məntəqə)--}}
{{--                                                @else--}}
{{--                                                    {{$item->filial->name}} (Filial)--}}
{{--                                                @endif--}}
{{--                                            </span>--}}
                                        @endif
                                    </div>

                                    <div class="col-lg-12 form-group mt-3">
                                        @include('front.form.group', ['type' => 'textarea', 'key' => 'address', 'label' => trans('front.address'), 'options' => ['class' => 'form__field', 'rows' => 4]])
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        @include('front.form.group', ['type' => 'select', 'key' => 'zip_code', 'label' => "Azər Poçt filialı", 'selects' => $azerpoct_branches, 'options' => ['id' => 'filial', 'class' => 'form__field']])
{{--                                        @include('front.form.group', ['key' => 'zip_code', 'label' => trans('front.zip_code'), 'options' => ['class' => 'form__field']])--}}
                                    </div>

                                    <div class="col-sm-6 form-group custom-check-box" style="padding-top: 25px">
                                        <label class="custom-control material-checkbox ">
                                            <input value="1"
                                                   @if($item->sent_by_post) checked @endif
                                                   type="checkbox"
                                                   name="sent_by_post"
                                                   class="material-control-input">
                                            <span class="material-control-indicator"></span>
                                            <span class="description">Azər Poçta göndər</span>
                                            <span class="help-block"> ( Əlavə ödəniş )</span>
                                        </label>
                                        <label class="custom-control material-checkbox ">
                                            <input value="1"
                                                   @if($item->campaign_notifications) checked
                                                   @endif type="checkbox"
                                                   name="campaign_notifications"
                                                   class="material-control-input">
                                            <span class="material-control-indicator"></span> <span class="description">Kampaniya bildirişləri</span>
                                        </label>
                                        <label class="custom-control material-checkbox ">
                                            <input value="1"
                                                   @if($item->auto_charge) checked
                                                   @endif type="checkbox"
                                                   name="auto_charge"
                                                   class="material-control-input">
                                            <span class="material-control-indicator"></span> <span class="description">Avto ödəmə</span>
                                        </label>
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        @include('front.form.group', ['type' => 'password', 'key' => 'password', 'label' => trans('front.password'), 'options' => ['placeholder' => trans('front.enter_new_password'), 'class' => 'form__field']])
                                    </div>
                                    <div class="col-sm-6 form-group">
                                        @include('front.form.group', ['type' => 'password', 'key' => 'password_confirmation', 'label' => trans('front.password_confirmation'), 'options' => ['placeholder' => trans('front.enter_password_confirmation'),'class' => 'form__field']])
                                    </div>

                                    <div class="col-lg-12 col-md-12 col-sm-12 form-group message-btn middle_smallbtn">
                                        <button type="submit" class="theme-btn-one">{{ __('front.save') }}<i
                                                    class="icon-Arrow-Right"></i></button>
                                    </div>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('js')
{{--    <script src="//unpkg.com/alpinejs" defer></script>--}}
{{--    <script>--}}
{{--        function dataStorage() {--}}
{{--            return {--}}
{{--                hasBranch: "{{is_numeric($item->branch_id)}}",--}}
{{--                sent_to: "{{is_numeric($item->branch_id) ? 'branch' : 'filial'}}",--}}
{{--                showArea(type) {--}}
{{--                    if (type === 'filial') {--}}
{{--                        this.hasBranch = false--}}
{{--                    }--}}
{{--                    if (type === 'branch') {--}}
{{--                        this.hasBranch = true--}}
{{--                    }--}}
{{--                }--}}
{{--            }--}}
{{--        }--}}
{{--    </script>--}}
@endpush