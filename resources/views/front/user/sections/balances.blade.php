<div class="feature-content">
    <div class="row clearfix">
        <div class="col-xl-3 col-lg-12 col-md-12 feature-block">
            <div class="feature-block-two">
                <div class="inner-box">
                    <div class="pattern">
                        <div class="pattern-1"
                             style="background-image: url({{ asset('assets/images/shape/shape-79.png') }});"></div>
                        <div class="pattern-2"
                             style="background-image: url({{ asset('assets/images/shape/shape-80.png') }});"></div>
                    </div>
                    <h3>{{ auth()->user()->total_discount }}%</h3>
                    <h5>{{ __('front.panel_header.discount') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-12 col-md-12 feature-block">
            <div class="feature-block-two">
                <div class="inner-box">
                    <div class="pattern">
                        <div class="pattern-1"
                             style="background-image: url({{ asset('assets/images/shape/shape-83.png') }});"></div>
                        <div class="pattern-2"
                             style="background-image: url({{ asset('assets/images/shape/shape-84.png') }});"></div>
                    </div>
                    <h3> {{ auth()->user()->orderBalance(true) }}</h3>
                    <h5>{{ __('front.panel_header.order_balance') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-12 col-md-12 feature-block">
            <div class="feature-block-two">
                <div class="inner-box">
                    <div class="pattern">
                        <div class="pattern-1"
                             style="background-image: url({{ asset('assets/images/shape/shape-81.png') }});"></div>
                        <div class="pattern-2"
                             style="background-image: url({{ asset('assets/images/shape/shape-82.png') }});"></div>
                    </div>
                    <h3> ${{ $spending['sum'] }}</h3>
                    <h5>{{ __('front.panel_header.monthly_limit') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-12 col-md-12 feature-block">
            <div class="feature-block-two">
                <div class="inner-box">
                    <div class="pattern">
                        <div class="pattern-1"
                             style="background-image: url({{ asset('assets/images/shape/shape-83.png') }});"></div>
                        <div class="pattern-2"
                             style="background-image: url({{ asset('assets/images/shape/shape-84.png') }});"></div>
                    </div>
                    <h3>{{ $spending['total'] }}</h3>
                    <h5>{{ __('front.panel_header.waiting_package') }}</h5>
                </div>
            </div>
        </div>
    </div>
</div>
