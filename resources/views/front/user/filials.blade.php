@extends('front.layout')

@section('content')
    <section class="doctors-dashboard bg-color-3">
        @if(auth()->check())
            @include('front.user.sections.sidebar_menu')
            <div class="right-panel">
                @else
                    <div>
                        @endif
                        <div class="content-container">
                            <div class="outer-container">

                                <div class="add-listing adress_box dash_mobile_hide full">
                                    <div class="single-box">
                                        <div class="row">
                                            <div class="col-md-12 address_tabs">
                                                <ul>
                                                    @foreach($filials as $key => $filial)
                                                        <li @if(! $key) class="active" @endif>
                                                            <a href="#country-{{ $filial->id }}">
                                                                {{ $filial->translateOrDefault($_lang)->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>

                                            @foreach($filials as $key => $filial)
                                                <div class="col-md-12 adress_info address_tab @if(! $key) active @endif"
                                                     id="country-{{ $filial->id }}">
                                                    <i class="fas fa-map"></i> : <span
                                                            style="color: #000">{{ $filial->translateOrDefault($_lang)->address }}</span>


                                                    @if($filial->phone )
                                                        <br/>
                                                        <i class="fas fa-phone"></i> : <span
                                                                style="color: #000">{{ $filial->phone }}</span>
                                                    @endif
                                                    @if($filial->working_hours )
                                                    <br/>
                                                    <i class="fas fa-clock"></i> : <span
                                                            style="color: #000">{{ $filial->working_hours }}</span>
                                                    @endif
                                                    <iframe src="{{ $filial->location }}" width="100%" height="450"
                                                            frameborder="0" style="border:0; margin-top: 20px"
                                                            allowfullscreen="" aria-hidden="false"
                                                            tabindex="0"></iframe>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

    </section>

@endsection