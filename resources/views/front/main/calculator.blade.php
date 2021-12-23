<!-- banner-section -->
<section class="banner-section style-two bg-color-1">
    <div class="hidden-xs hidden-sm">
        <div class="owl-carousel">
            @foreach($sliders as $slider)
                <div class="item">
                    <img src="{{ $slider->image }}" alt="">
                </div>
            @endforeach
        </div>
        <div class="pattern">
            <div class="pattern-1"
                 style="background-image: url({{ asset('assets/images/shape/shape-32.png') }});"></div>
            <div class="pattern-2"
                 style="background-image: url({{ asset('assets/images/shape/shape-33.png') }})');"></div>
            <div class="pattern-3"
                 style="background-image: url({{ asset('assets/images/shape/shape-34.png') }})');"></div>
            <div class="pattern-4"
                 style="background-image: url({{ asset('assets/images/shape/shape-35.png') }})');"></div>
        </div>
    </div>
    <div class="auto-container">
        <div class="row clearfix">
            <div class="col-lg-6 col-md-12 col-sm-12 content-column">
                <div class="content-box calculator_box">
                    <h2>{!! __('front.calculator.title') !!}</h2>

                    <div class="form-inner calculator_form">
                        <form id="calc_form" autocomplete="off" data-route="<?= route('calc_price'); ?>">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <select id="country" name="country" class="form__select">
                                        @foreach($countries as $country)
                                            <option data-display="{{ $country->translateOrDefault($_lang)->name }}"
                                                    value="{{ $country->id }}">{{ $country->translateOrDefault($_lang)->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input id="weight" name="weight" class="form__field" type="text"
                                           placeholder="{!! __('front.calculator.weight') !!}"/>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 form-group">
                                    <input id="height" name="height" type="text"
                                           placeholder="{!! __('front.calculator.height') !!}"
                                           class="form__field"/>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-4 col-xs-4 form-group">
                                    <input id="Lenght" name="length" type="text"
                                           placeholder="{!! __('front.calculator.length') !!} "
                                           class="form__field"/>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-4 col-xs-4 form-group">
                                    <input id="width" name="width" type="text"
                                           placeholder="{!! __('front.calculator.width') !!} " class="form__field"/>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-4 col-xs-4 form-group">
                                    <p class="calc_price">0.00 USD</p>
                                </div>

                                <div class="col-lg-12 form-group">
                                    <div class="calc_hint" style="background: #fff; padding: 20px;">{!! __('front.calculator.note') !!}</div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- banner-section end -->

