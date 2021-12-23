<!-- promo start-->
<div class="promo main_promo promo--f6">
    <div class="buttons_banner full">
        <div class="container">
            <div class="full plist_cont">
                <ul class="product_list">
                    @foreach($types as $type)
                        <li>
                            <a href="#" class="" data-price="2" data-count="0">
                                <img src="{{ $type->icon }}" alt="">
                                <span class="select_count"></span>

                            </a>
                            <button class="close_selected">
                                <img src="{{ asset('front/img/cl.svg') }}" alt="">
                            </button>
                            <p class="pro_name">{{ $type->translateOrDefault($_lang)->name }}</p>
                            <span class="pro_weight" data-weight="{{ round($type->weight, 2) }}">{{ round($type->weight, 2) }} kg</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @include('front.main.calculator')
</div>
<!-- promo end-->