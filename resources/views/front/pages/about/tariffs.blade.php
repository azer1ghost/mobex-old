@extends('front.layout')

@section('content')
    <section class="section faq pt-200">
        <div class="container">
            <div class="row">
                @include('front.pages.sidebar_menu')
                <div class="col-lg-8">
                    <div class="tabs horizontal-tabs top-40 adress_tabs_container">
                        <ul class="horizontal-tabs__header adrress_tabs">
                            @foreach($countries as $key => $country)

                                <li>
                                    <a href="#horizontal-tabs__item-{{ $country->id }}"
                                       role="tab"
                                       data-toggle="tab">
                                        <span>
                                            <img width="25px" src="{{ $country->flag }}" alt="img"/>
                                            {{ str_limit($country->translateOrDefault($_lang)->name, 25) }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="horizontal-tabs__content">
                            @foreach($countries_t as $key => $country)
                                <div role="tabpanel"
                                     class="horizontal-tabs__item fade in @if(!$key) active @endif"
                                     id="horizontal-tabs__item-{{ $country->id }}">
                                    <table class="adress_table">
                                        <tbody>
                                        <tr>
                                            <td>
                                                <label>{{ __('front.tariff.title') }}</label>
                                            </td>
                                            <td>
                                                <label>{{ __('front.tariff.weight') }}</label>
                                            </td>
                                        </tr>
                                        @if($country->warehouse->per_g)
                                            @if($country->warehouse->half_kg)
                                                <tr>
                                                    <td>
                                                        <label>{{ __('front.tariff.half_kg') }}</label>
                                                    </td>
                                                    <td>
                                                        <p>{{ $country->warehouse->half_kg }} {{ $country->warehouse->currency_with_label }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>
                                                    <label>{{ __('front.tariff.per_g') }}</label>
                                                </td>
                                                <td>
                                                    <p>{{ $country->warehouse->per_g }} {{ $country->warehouse->currency_with_label }}</p>
                                                </td>
                                            </tr>
                                        @else
                                            @if($country->warehouse->to_100g)
                                                <tr>
                                                    <td>
                                                        <label>{{ __('front.tariff.to_100g') }}</label>
                                                    </td>
                                                    <td>
                                                        <p>{{ $country->warehouse->to_100g }} {{ $country->warehouse->currency_with_label }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($country->warehouse->from_100g_to_200g)
                                                <tr>
                                                    <td>
                                                        <label>{{ __('front.tariff.from_100g_to_200g') }}</label>
                                                    </td>
                                                    <td>
                                                        <p>{{ $country->warehouse->from_100g_to_200g }} {{ $country->warehouse->currency_with_label }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($country->warehouse->from_200g_to_500g)
                                                <tr>
                                                    <td>
                                                        <label>{{ __('front.tariff.from_200g_to_500g') }}</label>
                                                    </td>
                                                    <td>
                                                        <p>{{ $country->warehouse->from_200g_to_500g }} {{ $country->warehouse->currency_with_label }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($country->warehouse->from_500g_to_750g)
                                                <tr>
                                                    <td>
                                                        <label>{{ __('front.tariff.from_500g_to_750g') }}</label>
                                                    </td>
                                                    <td>
                                                        <p>{{ $country->warehouse->from_500g_to_750g }} {{ $country->warehouse->currency_with_label }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($country->warehouse->from_750g_to_1kq)
                                                <tr>
                                                    <td>
                                                        <label>{{ __('front.tariff.from_750g_to_1kq') }}</label>
                                                    </td>
                                                    <td>
                                                        <p>{{ $country->warehouse->from_750g_to_1kq }} {{ $country->warehouse->currency_with_label }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            @if($country->warehouse->half_kg)
                                                <tr>
                                                    <td>
                                                        <label>{{ __('front.tariff.half_kg') }}</label>
                                                    </td>
                                                    <td>
                                                        <p>{{ $country->warehouse->half_kg }} {{ $country->warehouse->currency_with_label }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <td>
                                                    <label>{{ $country->warehouse->from_500g_to_1kq ? __('front.tariff.per_kg_extra') : __('front.tariff.per_kg_extra') }}</label>
                                                </td>
                                                <td>
                                                    <p>{{ $country->warehouse->per_kg }} {{ $country->warehouse->currency_with_label }}</p>
                                                </td>
                                            </tr>
                                            @if($country->warehouse->per_kg != $country->warehouse->up_10_kg)
                                                <tr>
                                                    <td>
                                                        <label>{{ __('front.tariff.per_10_kg') }}</label>
                                                    </td>
                                                    <td>
                                                        <p>{{ $country->warehouse->up_10_kg }} {{ $country->warehouse->currency_with_label }}</p>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
    <style>
        .form__field {
            background-color: white;
        }
    </style>
@endpush