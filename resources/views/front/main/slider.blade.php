<div class="promo main_promo promo--f6">
    <div class="promo-slider">
        @foreach($sliders as $slider)
            <div class="promo-slider__item">
                <div class="promo-slider__layout"></div>
                <picture>
                    <source srcset="{{ asset($slider->image) }}" media="(min-width: 992px)"/>
                    <img class="img--bg" src="{{ asset($slider->image) }}"  alt="{{ $slider->translateOrDefault($_lang)->title }}"/>
                </picture>
                <div class="align-container">
                    <div class="align-container__item">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-10 offset-lg-1 text-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    @include('front.main.calculator')
</div>
