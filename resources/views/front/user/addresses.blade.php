@extends('front.layout')

@section('content')
    <section class="doctors-dashboard bg-color-3">
        @include('front.user.sections.sidebar_menu')
        <div class="right-panel">
            <div class="content-container">
                <div class="outer-container">
                    @include('front.user.sections.balances')


                    <div class="add-listing adress_box dash_mobile_hide full">
                        <div class="single-box">
                            <div class="row">
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

                                @foreach($countries as $key => $country)
                                    <div class="col-md-12 adress_info address_tab @if(! $key) active @endif"
                                         id="country-{{ $country->id }}">
                                        @foreach($country->warehouses as $warehouse)
                                            @if($warehouse->addresses->count())
                                                @foreach($warehouse->addresses as $addresses)
                                                    @if(view()->exists('front.user.addresses.' . strtolower($country->code)))
                                                        @include('front.user.addresses.' . strtolower($country->code))
                                                    @else
                                                        @include('front.user.addresses.default')
                                                    @endif
                                                    <br/>
                                                @endforeach
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach

                                <div class="alert alert-danger">
                                    {{ __('front.user_address.alert', ["code" => auth()->user()->customer_id]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

@endsection