<!-- pricing-section -->
<section class="pricing-section main_pricing_section bg-color-3 sec-pad" id="tariff">
    <div class="auto-container">
        <div class="sec-title centred">
            <p>{!! __('front.tariff.title') !!}</p>
            <h2>  {!! __('front.tariff.sub_title') !!}</h2>
        </div>
        <div class="add-listing  adress_box dash_mobile_hide full">
            <div class="single-box main_page_country_tabs">
                <div class="row">
                    <!-- dashboard link slider -->
                    <div class="col-md-12 address_tabs">
                        <ul>
                            @foreach($countries as $key => $country)
                                <li @if(! $key) class="active" @endif>
                                    <a href="#country-{{ $country->id }}">
                                        <img src="{{ asset($country->flag) }}" alt=""/>
                                        {{ $country->translateOrDefault($_lang)->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- dashboard link slider edn-->
                    <!-- unvanlar-->
                    <!--tab1-->
                    @foreach($countries as $key => $country)
                        <div class="col-md-12 adress_info address_tab @if(! $key) active @endif"
                             id="country-{{ $country->id }}">
                            <div class="tabs-box">
                                <div class="tab-btn-box centred">
                                    <ul class="tab-btns tab-buttons clearfix"
                                        @if (! $country->warehouse->has_liquid) style="display: none !important;" @endif >
                                        <li class="tab-btn active-btn" data-tab="#tab-gen-{{ $country->id }}">
                                            {{ __('additional.general') }}
                                        </li>
                                        @if ($country->warehouse->has_liquid)
                                            <li class="tab-btn"
                                                data-tab="#tab-liq-{{ $country->id }}">{{ __('additional.liquid') }}</li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="tabs-content">
                                    <div class="tab active-tab" id="tab-gen-{{ $country->id }}">
                                        <div class="row clearfix">
                                            <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                <div class="pricing-block-one">
                                                    <div class="pricing-table">

                                                        <div class="table-header">
                                                            <h3>  @if($country->warehouse->discount_user)<span
                                                                        style="text-decoration: line-through;">@endif{{ $country->warehouse->to_100g ? $country->warehouse->to_100g : $country->warehouse->half_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->discount_user)</span>@endif
                                                                @if($country->warehouse->discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->to_100g ? $country->warehouse->to_100g : $country->warehouse->half_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                            </h3>
                                                        </div>
                                                        <div class="table-content">
                                                            <ul class="list clearfix">
                                                                <li>{!! __('front.tariff.to_100g') !!}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                <div class="pricing-block-one">
                                                    <div class="pricing-table">

                                                        <div class="table-header">
                                                            <h3>@if($country->warehouse->discount_user)<span
                                                                        style="text-decoration: line-through;">@endif{{ $country->warehouse->from_100g_to_200g ? $country->warehouse->from_100g_to_200g : $country->warehouse->half_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->discount_user)</span>@endif
                                                                @if($country->warehouse->discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->from_100g_to_200g ? $country->warehouse->from_100g_to_200g : $country->warehouse->half_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                            </h3>
                                                        </div>
                                                        <div class="table-content">
                                                            <ul class="list clearfix">
                                                                <li>{!! __('front.tariff.from_100g_to_200g') !!}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                <div class="pricing-block-one">
                                                    <div class="pricing-table">

                                                        <div class="table-header">
                                                            <h3>  @if($country->warehouse->discount_user)<span
                                                                        style="text-decoration: line-through;">@endif{{ $country->warehouse->from_200g_to_500g ? $country->warehouse->from_200g_to_500g : $country->warehouse->half_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->discount_user)</span>@endif
                                                                @if($country->warehouse->discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->from_200g_to_500g ? $country->warehouse->from_200g_to_500g : $country->warehouse->half_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                            </h3>
                                                        </div>
                                                        <div class="table-content">
                                                            <ul class="list clearfix">
                                                                <li>{!! __('front.tariff.from_200g_to_500g') !!}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                <div class="pricing-block-one">
                                                    <div class="pricing-table">

                                                        <div class="table-header">
                                                            <h3> @if($country->warehouse->discount_user)<span
                                                                        style="text-decoration: line-through;">@endif{{ $country->warehouse->from_500g_to_750g ? $country->warehouse->from_500g_to_750g : $country->warehouse->per_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->discount_user)</span>@endif
                                                                @if($country->warehouse->discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->from_500g_to_750g ? $country->warehouse->from_500g_to_750g : $country->warehouse->per_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                            </h3>
                                                        </div>
                                                        <div class="table-content">
                                                            <ul class="list clearfix">
                                                                <li>{!! __('front.tariff.from_500g_to_750g') !!}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                <div class="pricing-block-one">
                                                    <div class="pricing-table">

                                                        <div class="table-header">
                                                            <h3>  @if($country->warehouse->discount_user)<span
                                                                        style="text-decoration: line-through;">@endif{{ $country->warehouse->from_750g_to_1kq ? $country->warehouse->from_750g_to_1kq : $country->warehouse->per_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->discount_user)</span>@endif
                                                                @if($country->warehouse->discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->from_750g_to_1kq ? $country->warehouse->from_750g_to_1kq : $country->warehouse->per_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                            </h3>
                                                        </div>
                                                        <div class="table-content">
                                                            <ul class="list clearfix">
                                                                <li>{!! __('front.tariff.from_750g_to_1kq') !!}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if($country->warehouse->per_kg)
                                                <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                    <div class="pricing-block-one">
                                                        <div class="pricing-table">

                                                            <div class="table-header">
                                                                <h3 style="display: inline">
                                                                    @if($country->warehouse->discount_user)<span
                                                                            style="text-decoration: line-through;">@endif{{ $country->warehouse->per_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->discount_user)</span>@endif
                                                                    @if($country->warehouse->discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->per_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                                </h3>
                                                                <small style="display: inline"> (hər kg üçün)</small>
                                                            </div>
                                                            <div class="table-content">
                                                                <ul class="list clearfix">
                                                                    <li>{!! __('front.tariff.per_kg_extra') !!}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($country->warehouse->from_1kq_to_5kq && $country->warehouse->from_1kq_to_5kq != $country->warehouse->per_kg)
                                                <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                    <div class="pricing-block-one">
                                                        <div class="pricing-table">

                                                            <div class="table-header">
                                                                <h3>
                                                                    @if($country->warehouse->discount_user)<span
                                                                            style="text-decoration: line-through;">@endif{{ $country->warehouse->from_1kq_to_5kq }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->discount_user)</span>@endif
                                                                    @if($country->warehouse->discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->from_1kq_to_5kq), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                                </h3>
                                                            </div>
                                                            <div class="table-content">
                                                                <ul class="list clearfix">
                                                                    <li>{!! __('front.tariff.1_5_kg') !!} </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($country->warehouse->from_5kq_to_10kq && $country->warehouse->from_5kq_to_10kq != $country->warehouse->per_kg)
                                                <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                    <div class="pricing-block-one">
                                                        <div class="pricing-table">

                                                            <div class="table-header">
                                                                <h3 style="display: inline">
                                                                    @if($country->warehouse->discount_user)<span
                                                                            style="text-decoration: line-through;">@endif{{ $country->warehouse->from_5kq_to_10kq }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->discount_user)</span>@endif
                                                                    @if($country->warehouse->discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->from_5kq_to_10kq), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                                </h3>
                                                                <small style="display: inline"> (hər kg üçün)</small>
                                                            </div>
                                                            <div class="table-content">
                                                                <ul class="list clearfix">
                                                                    <li>{!! __('front.tariff.5_10_kg') !!}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($country->warehouse->up_10_kg && $country->warehouse->up_10_kg != $country->warehouse->per_kg)
                                                <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                    <div class="pricing-block-one">
                                                        <div class="pricing-table">

                                                            <div class="table-header">
                                                                <h3 style="display: inline">
                                                                    @if($country->warehouse->discount_user)<span
                                                                            style="text-decoration: line-through;">@endif{{ $country->warehouse->up_10_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->discount_user)</span>@endif
                                                                    @if($country->warehouse->discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->up_10_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                                </h3>
                                                                <small style="display: inline"> (hər kg üçün)</small>
                                                            </div>
                                                            <div class="table-content">
                                                                <ul class="list clearfix">
                                                                    <li>{!! __('front.tariff.per_10_kg') !!} </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    @if ($country->warehouse->has_liquid)
                                        <div class="tab" id="tab-liq-{{ $country->id }}">
                                            <div class="row clearfix">
                                                <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                    <div class="pricing-block-one">
                                                        <div class="pricing-table">

                                                            <div class="table-header">
                                                                <h3> @if($country->warehouse->liquid_discount_user)<span
                                                                            style="text-decoration: line-through;">@endif{{ $country->warehouse->l_to_100g ? $country->warehouse->l_to_100g : $country->warehouse->l_half_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->liquid_discount_user)</span>@endif
                                                                    @if($country->warehouse->liquid_discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->l_to_100g ? $country->warehouse->l_to_100g : $country->warehouse->l_half_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                                </h3>
                                                            </div>
                                                            <div class="table-content">
                                                                <ul class="list clearfix">
                                                                    <li>{!! __('front.tariff.to_100g') !!}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                    <div class="pricing-block-one">
                                                        <div class="pricing-table">

                                                            <div class="table-header">
                                                                <h3> @if($country->warehouse->liquid_discount_user)<span
                                                                            style="text-decoration: line-through;">@endif{{ $country->warehouse->l_from_100g_to_200g ? $country->warehouse->l_from_100g_to_200g : $country->warehouse->l_half_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->liquid_discount_user)</span>@endif
                                                                    @if($country->warehouse->liquid_discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->l_from_100g_to_200g ? $country->warehouse->l_from_100g_to_200g : $country->warehouse->l_half_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                                </h3>
                                                            </div>
                                                            <div class="table-content">
                                                                <ul class="list clearfix">
                                                                    <li>{!! __('front.tariff.from_100g_to_200g') !!}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                    <div class="pricing-block-one">
                                                        <div class="pricing-table">

                                                            <div class="table-header">
                                                                <h3> @if($country->warehouse->liquid_discount_user)<span
                                                                            style="text-decoration: line-through;">@endif{{ $country->warehouse->l_from_200g_to_500g ? $country->warehouse->l_from_200g_to_500g : $country->warehouse->l_half_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->liquid_discount_user)</span>@endif
                                                                    @if($country->warehouse->liquid_discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->l_from_200g_to_500g ? $country->warehouse->l_from_200g_to_500g : $country->warehouse->l_half_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                                </h3>
                                                            </div>
                                                            <div class="table-content">
                                                                <ul class="list clearfix">
                                                                    <li>{!! __('front.tariff.from_200g_to_500g') !!}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                    <div class="pricing-block-one">
                                                        <div class="pricing-table">

                                                            <div class="table-header">
                                                                <h3>    @if($country->warehouse->liquid_discount_user)
                                                                        <span style="text-decoration: line-through;">@endif{{ $country->warehouse->l_from_500g_to_750g ? $country->warehouse->l_from_500g_to_750g : $country->warehouse->l_per_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->liquid_discount_user)</span>@endif
                                                                    @if($country->warehouse->liquid_discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->l_from_500g_to_750g ? $country->warehouse->l_from_500g_to_750g : $country->warehouse->l_per_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                                </h3>
                                                            </div>
                                                            <div class="table-content">
                                                                <ul class="list clearfix">
                                                                    <li>{!! __('front.tariff.from_500g_to_750g') !!}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                    <div class="pricing-block-one">
                                                        <div class="pricing-table">

                                                            <div class="table-header">
                                                                <h3>    @if($country->warehouse->liquid_discount_user)
                                                                        <span style="text-decoration: line-through;">@endif{{ $country->warehouse->l_from_750g_to_1kq ? $country->warehouse->l_from_750g_to_1kq : $country->warehouse->l_per_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->liquid_discount_user)</span>@endif
                                                                    @if($country->warehouse->liquid_discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->l_from_750g_to_1kq ? $country->warehouse->l_from_750g_to_1kq : $country->warehouse->l_per_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                                </h3>
                                                            </div>
                                                            <div class="table-content">
                                                                <ul class="list clearfix">
                                                                    <li>{!! __('front.tariff.from_750g_to_1kq') !!}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-4 col-md-3 col-sm-12 pricing-block">
                                                    <div class="pricing-block-one">
                                                        <div class="pricing-table">

                                                            <div class="table-header">
                                                                <h3> @if($country->warehouse->liquid_discount_user)<span
                                                                            style="text-decoration: line-through;">@endif{{ $country->warehouse->l_per_kg }} {{ $country->warehouse->currency_with_label }}@if($country->warehouse->liquid_discount_user)</span>@endif
                                                                    @if($country->warehouse->liquid_discount_user) {{ round((1 - $country->warehouse->discount_user/100) * ($country->warehouse->l_per_kg), 2) }} {{ $country->warehouse->currency_with_label }} @endif
                                                                </h3>
                                                            </div>
                                                            <div class="table-content">
                                                                <ul class="list clearfix">
                                                                    <li>{!! __('front.tariff.per_kg_extra') !!}</li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</section>
<!-- pricing-section end -->