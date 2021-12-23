<section class="section pb-0 services_2 bg--lgray">
    <div class="row bottom-70">
        <div class="col-12">
            <div class="heading heading--center">
                <span class="heading__pre-title">
                     {!! __('front.promo.title') !!}
                </span>
                <h3 class="heading__title">
                    {!! __('front.promo.sub_title') !!}
                </h3>
            </div>
        </div>
    </div>
    <div class="container container--wide">
        <div class="row offset-50">
            @foreach($promos as $key=>$promo)
                <a target="_blank" href="{{ $promo->url }}">
                    <div class="col-md-6 col-xl-3">
                        <div class="img-box">
                            <div class="img-box__overlay"></div>
                            <div class="img-box__text-layout">
                                {!! $promo->translateOrDefault($_lang)->name !!}
                            </div>
                            <img class="img--bg" src="{{ asset($promo->image) }}" alt="img"/>
                            <div class="img-box__details">
                                <h5 class="img-box__title">
                                    <a target="_blank" href="{{ $promo->url }}">
                                        {!! $promo->store ? $promo->store->translateOrDefault($_lang)->name : null !!}
                                    </a></h5>
                                <div class="img-box__count">{!! "0" . strval($key+1) !!}</div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>