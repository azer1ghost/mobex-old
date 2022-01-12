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
                    <h1>{{ __('front.user_packages.title') }}</h1>
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
                    <div class="declare_box add-listing doctor-details-content clinic-details-content full">
                        <div class="row single-box">
                            <!-- dashboard link slider -->
                            <div class="tabs-box">
                                <div class="tab-btn-box centred">
                                    <ul class="tab-btns tab-buttons clearfix">
                                        <li @if($id == 6) class="active-btn" @endif>
                                            <a href="{{ route('my-packages', ['id' => 6]) }}">
                                                {{ ucfirst(strtolower(__('front.early_declaration'))) }}
                                                @if(isset($counts[6]))
                                                    <b class="c-label">{{ $counts[6] or null }}</b>
                                                @endif
                                            </a>
                                        </li>
                                        <li @if($id == 0) class="active-btn" @endif>
                                            <a href="{{ route('my-packages') }}">
                                                {{ ucfirst(strtolower(__('front.in_store'))) }}
                                                @if(isset($counts[0]))
                                                    <b class="c-label">{{ $counts[0] or null }}</b>
                                                @endif
                                            </a>
                                        </li>
                                        <li @if($id == 1) class="active-btn" @endif>
                                            <a href="{{ route('my-packages', ['id' => 1]) }}">
                                                {{ ucfirst(strtolower(__('front.was_sent'))) }}
                                                @if(isset($counts[1]))
                                                    <b class="c-label">{{ $counts[1] or null }}</b>
                                                @endif
                                            </a>
                                        </li>
                                        <li @if($id == 2) class="active-btn" @endif>
                                            <a href="{{ route('my-packages', ['id' => 2]) }}">
                                                {{ ucfirst(strtolower(__('front.in_baku'))) }}
                                                @if(isset($counts[2]))
                                                    <b class="c-label">{{ $counts[2] or null }}</b>
                                                @endif
                                            </a>
                                        </li>
                                        <li @if($id == 7) class="active-btn" @endif>
                                            <a href="{{ route('my-packages', ['id' => 7]) }}">
                                                {{ ucfirst(strtolower(__('front.courier_packages'))) }}
                                                @if(isset($counts[7]))
                                                    <b class="c-label">{{ $counts[7] or null }}</b>
                                                @endif
                                            </a>
                                        </li>
                                        <li @if($id == 3) class="active-btn" @endif>
                                            <a href="{{ route('my-packages', ['id' => 3]) }}">
                                                {{ ucfirst(strtolower(__('front.done_packages'))) }}
                                                @if(isset($counts[3]))
                                                    <b class="c-label">{{ $counts[3] or null }}</b>
                                                @endif
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tabs-content">
                                    <div class="tab active-tab" id="tab-1">
                                        <div class="inner-box">
                                            <div class="accordion-box">
                                                @if ( request()->has('success'))
                                                    <div class="alert alert-success" role="alert">{{ __('front.was_paid') }}</div>
                                                @endif
                                                @if ( request()->has('error'))
                                                    <div class="alert alert-danger" role="alert">{{ request()->get('error') }}</div>
                                                @endif
                                                @if (session('success'))
                                                    <div class="alert alert-success" role="alert">{{ __('front.declaration_updated') }}</div>
                                                @endif
                                                @if($packages->count() and 0 === $id)
                                                    {{--                                                        <div class="alert alert-info" role="alert">{{ __('front.user_packages_info') }}</div>--}}
                                                    <div class="alert alert-info" role="alert">
                                                        Bağlamalar bir neçə dəqiqə ərzində Smart Customs ilə eyniləşdirilir.
                                                    </div>
                                                @endif

                                                @if($packages->count())
                                                    <div class="title-box">
                                                        <h6>{{ __('front.user_side_menu.baglama') }}</h6>
                                                    </div>
                                                    <ul class="accordion-inner">
                                                        @foreach($packages as $package)

                                                            @php
                                                                $isEarlyDeclared = $package->status === 6;
                                                                $isInWarehouse = $package->status === 0;
                                                                $inCustoms = $package->custom_status === 0;
                                                                $notInCustoms = $package->custom_status === null;
                                                                $reloadUserPackages = auth()->user()->refresh_customs;

                                                                // Beyanli
                                                                $isDeclared = $package->custom_status >= 1;

                                                                // Eskik melumat
                                                                $missingInformation = $package->shipping_amount <= 0;

                                                                // Son 7 deqiqe erzinde deyisdiirlib
                                                                $recentlyUpdated = $package->updated_at->diffInMinutes(now()) < 7;

                                                                // Yenileme Gozlemede
                                                                $isWaiting = !$missingInformation && ( ($inCustoms && $recentlyUpdated && $reloadUserPackages) || $notInCustoms);
                                                            @endphp

                                                            <li class="accordion block">
                                                                <div class="acc-btn">
                                                                    <div class="icon-outer"></div>
                                                                    <h6>
                                                                        @if($package->custom_status !== null)
                                                                            {!! str_repeat('✅ ', $package->custom_status + 1) !!}
                                                                        @endif
                                                                        {{ $package->website_name  }}
                                                                        @if($package->country)
                                                                                ({{ $package->country->translateOrDefault($_lang)->name }})
                                                                        @endif
                                                                        -  № {{  $package->custom_id  }}

                                                                        @if($isInWarehouse)
                                                                            @if($missingInformation)
                                                                                (Bağlamanın çatışmayan məlumatları var)
                                                                                <i class="fa fa-exclamation-triangle text-danger float-right mr-2"></i>
                                                                            @else
                                                                                @if($isWaiting)
                                                                                    <i class="fa fa-repeat text-info float-right mr-2"></i>
                                                                                @else
                                                                                    @if($isDeclared)
                                                                                        <span class="badge badge-success">Bəyanlı</span>
                                                                                    @else
                                                                                        <span class="badge badge-danger">Bəyan olunmayıb</span>
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                        @endif

                                                                    </h6>
                                                                </div>
                                                                <div class="acc-content">
                                                                    <div class="accordion__text-block"
                                                                         style="display: block;">
                                                                        <ul class="list list--check list--reset">
                                                                            <li class="list__item"><strong>
                                                                                    {{ __('front.user_packages.order_date') }}
                                                                                </strong> {{ $package->created_at->format('d.m.y') }}
                                                                            </li>
                                                                            <li class="list__item">
                                                                                <strong>{{  __('front.tracking_code') }}:</strong>
                                                                                {{  $package->custom_id  }}
                                                                            </li>
                                                                            <li class="list__item">
                                                                                <strong>{{  __('front.tracking_code_or_order') }}:</strong>
                                                                                {{ $package->tracking_code  }}
                                                                            </li>
                                                                            <li class="list__item"><strong>
                                                                                    {{ __('front.user_packages.store') }}
                                                                                </strong>
                                                                                {{ $package->website_name  }}
                                                                            </li>
                                                                            <li class="list__item">
                                                                                <strong>{{ __('front.number_items') }}</strong>
                                                                                {{ $package->number_items or '-' }}
                                                                            </li>
                                                                            @if($id != 6)
                                                                                <li class="list__item">
                                                                                    <strong>{{ __('additional.package_page.weight') }}</strong>
                                                                                    {{ $package->weight }} {{ $package->weight_unit }}
                                                                                </li>
                                                                                @if($package->shipping_amount)
                                                                                    <li class="list__item">
                                                                                        <strong>
                                                                                            {{ __('front.user_packages.price') }}
                                                                                        </strong>
                                                                                        {{ $package->shipping_org_price }}
                                                                                    </li>
                                                                                @endif
                                                                                <li class="list__item">
                                                                                    <strong>
                                                                                        {{ __('front.delivery_price') }}
                                                                                    </strong>
                                                                                    {{ $package->delivery_price ? $package->delivery_price_with_label: '-' }}
                                                                                </li>
                                                                            @endif
                                                                           {{-- <li class="list__item"><strong>
                                                                                    {{ __('front.user_packages.status') }}
                                                                                </strong>
                                                                                {{ $package->getStatusWithLabelAttribute() }}
                                                                            </li>--}}

                                                                            <li class="list__item">
                                                                                <strong>
                                                                                    {{ __('front.user_packages.declaration') }}
                                                                                </strong>
                                                                                <a target="_blank"
                                                                                   href="{{ $package->invoice }}">{{ __('additional.package_page.invoice') }}</a>
                                                                            </li>
                                                                            <li class="list__item">
                                                                                <strong>
                                                                                    {{ __('front.product_category') }} :
                                                                                </strong>
                                                                                {{ $package->customs_type }}
                                                                            </li>
                                                                            @if($package->user_comment)
                                                                                <li class="list__item">
                                                                                    <strong>
                                                                                        {{ __('front.note') }}
                                                                                    </strong>
                                                                                    {{ $package->user_comment }}
                                                                                </li>
                                                                            @endif
                                                                        </ul>

                                                                        @if($isInWarehouse)
                                                                            @if($missingInformation)
                                                                                <p class="text-danger m-2">
                                                                                    Bağlamanın çatışmayan məlumatları var
                                                                                </p>
                                                                            @else
                                                                                @if($isWaiting)
                                                                                    <p class="text-danger m-2">
                                                                                        Bağlama bir neçə dəqiqə sonra customs-a yenilənəcək.
                                                                                    </p>
                                                                                @else
                                                                                    @if(!$isDeclared)
                                                                                        <p class="text-danger m-2">
                                                                                            Bağlama customs-da bəyan olunmayıb
                                                                                        </p>
                                                                                    @endif
                                                                                @endif
                                                                            @endif
                                                                            <hr/>
                                                                        @endif

                                                                        @foreach($package->links() as $key => $product)
                                                                            <div class="my_orders_orderbox">
                                                                                <div class="full-size">
                                                                                    <h6 class="count-item__title">
                                                                                        <span class="count-item__count">{{ sprintf("%02d", $key + 1) }}</span>
                                                                                        <span>{{ __('additional.product') }}</span>
                                                                                    </h6>
                                                                                </div>
                                                                                <ul class="list list--check list--reset">
                                                                                    <li class="list__item"><strong>
                                                                                            {{ __('front.user_orders.store') }}
                                                                                        </strong>
                                                                                        {{ getOnlyDomainWithExt($product->url) }}
                                                                                    </li>
                                                                                    <li class="list__item"><strong>
                                                                                            {{ __('front.user_orders.order_count') }}
                                                                                        </strong>
                                                                                        {{ $product->amount }}
                                                                                    </li>
                                                                                    <li class="list__item"><strong>
                                                                                            {{ __('front.user_orders.color') }}
                                                                                        </strong>
                                                                                        {{ $product->color }}
                                                                                    </li>
                                                                                    <li class="list__item"><strong>
                                                                                            {{ __('front.user_orders.size') }}
                                                                                        </strong>
                                                                                        {{ $product->size }}
                                                                                    </li>
                                                                                    <li class="list__item"><strong>
                                                                                            {{ __('front.user_orders.price') }}
                                                                                        </strong>
                                                                                        {{ $product->price }} TRY
                                                                                    </li>
                                                                                    <li class="list__item"><strong>
                                                                                            {{ __('front.user_orders.cargo_price') }}
                                                                                        </strong>
                                                                                        {{ $product->cargo_fee }} TRY
                                                                                    </li>
                                                                                    <li class="list__item"><strong>
                                                                                            {{ __('front.user_orders.total_price') }}
                                                                                        </strong>
                                                                                        {{ $product->total_price }} TRY
                                                                                    </li>
                                                                                    <li class="list__item"><strong>
                                                                                            {{ __('front.user_orders.link') }}
                                                                                        </strong>
                                                                                        <a target="_blank"
                                                                                           href="{{ $product->url }}"> {{ str_limit($product->url, 35) }}</a>
                                                                                    </li>
                                                                                </ul>
                                                                            </div>
                                                                        @endforeach
                                                                        <div class="full accordion_inbutton_cont">

                                                                            @if($package->custom_status < 1)
                                                                                <div class="col-lg-3 col-md-4 col-sm-12 form-group message-btn accordion_inbutton">
                                                                                    <a href="{{ route('declaration.edit', $package->id) }}" class="theme-btn-one">
                                                                                        {{ __('front.edit') }}
                                                                                        <i class="icon-Arrow-Right"></i>
                                                                                    </a>
                                                                                </div>
                                                                                @if(! $package->paid && $isEarlyDeclared)
                                                                                    <div class="col-lg-3 col-md-4 col-sm-12 form-group message-btn accordion_inbutton">
                                                                                        <a href="{{ route('declaration.delete', $package->id) }}" class="theme-btn-one" style="background-color: #ff1c90">
                                                                                            {{ trans('front.delete') }}
                                                                                            <i class="icon-Arrow-down-4"></i>
                                                                                        </a>
                                                                                    </div>
                                                                                @endif
                                                                            @endif
                                                                            {!! (new App\Models\Payments\PortManat())->generateForm($package) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                        @if (! session('success'))
                                                            <div class="alert alert-warning"
                                                                 role="alert">{{ __('front.no_any_package') }}</div>
                                                        @endif
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </section>

@endsection

