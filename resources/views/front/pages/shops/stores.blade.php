@extends('front.layout')

@section('content')

    <!-- dashboard-section -->
    <section class="dashboard-section shops_section bg-color-3">
        <div class="left-panel">
            <div class="profile-box patient-profile">

                <div class="profile-info">
                    <div class="div clearfix">
                        <form class="full-size clearfix">
                            <div class="shop_search full-size">
                                <input value="{{ request()->get('q') }}" class="form__field"
                                       type="text" id="search_input" name="q" placeholder="{{ __('front.search') }}"/>
                                <button type="submit" class="shop_search">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                    <ul class="list clearfix">
                        @foreach($categories as $category)
                            <li class="@if(request()->get('cat') == $category->id) current @endif"
                                value="{{ $category->id }}">
                                <a href="{{ route('shop','cat='.$category->id) }}">{!! $category->translateOrDefault($_lang)->name !!}</a><span>{{ $category->stores->count() }}</span>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
        <div class="right-panel shop_right_panel">
            <div class="content-container">
                <div class="outer-container">
                    <div class="favourite-doctors">
                        <div class="title-box shop_title_box">
                            <h3>{!! __('front.stores.overall_stores') !!} {!! $count_stores !!}</h3>
                        </div>

                        <div class="doctors-list shop_cards">
                            <div class="row clearfix">

                                @foreach($items as $key => $store)

                                    <div class="col-xl-3 col-sm-3 col-md-3 col-lg-3 doctors-block">
                                        <div class="team-block-three">
                                            <div class="inner-box">
                                                <figure class="image-box">
                                                    <img src="{{ asset($store->logo) }}" alt="{!! $store->name !!}">
                                                </figure>
                                                <div class="lower-content">
                                                    {{--<ul class="name-box clearfix">
                                                        <li class="name"><h3><a target="_blank"
                                                                                href="{{ $store->url }}">{!! $store->name !!}</a>
                                                            </h3></li>
                                                        <li><i class="icon-Trust-1"></i></li>
                                                    </ul>--}}
                                                    @if($store->featured)
                                                        <div class="rating-box clearfix">
                                                            <ul class="rating clearfix">
                                                                <li><i class="icon-Star"></i></li>
                                                                <li><i class="icon-Star"></i></li>
                                                                <li><i class="icon-Star"></i></li>
                                                                <li><i class="icon-Star"></i></li>
                                                                <li><i class="icon-Star"></i></li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    @if($store->country)
                                                        <div class="location-box">
                                                            <p>
                                                                <i class="fas fa-map-marker-alt"></i>{!! $store->country->translateOrDefault(app()->getLocale())->name  !!}
                                                            </p>
                                                        </div>
                                                    @endif
                                                    <div class="lower-box clearfix">

                                                        <a target="_blank"
                                                           href="{{ $store->cashback_link }}">{{ __('front.stores.to_website') }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="pagination-wrapper">
                            @include('front.widgets.pagination', ['paginator' => $items])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection