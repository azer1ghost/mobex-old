

<!-- clients-section -->
<section class="clients-section bg-white">
    <div class="pattern-layer">
        <div class="pattern-1" style="background-image: url({{ asset('assets/images/shape/shape-3.png') }});"></div>
        <div class="pattern-2" style="background-image: url({{ asset('assets/images/shape/shape-4.png') }});"></div>
    </div>
    <div class="auto-container">
        <div class="auto-container">
            <div class="clients-carousel owl-carousel owl-theme owl-nav-none owl-dots-none">
                @foreach($stores as $store)
                    <figure class="clients-logo-box">
                        <a title="{{ $store->name }}-dən sifariş və Azərbaycana çatdırılma" href="{{ $store->cashback_link }}" target="_blank">
                            <img src="{{ asset($store->logo) }}" alt="{{ $store->name }}-dən sifariş və Azərbaycana çatdırılma"/>
                        </a>
                    </figure>
                @endforeach
            </div>
        </div>
    </div>
</section>
<!-- clients-section end -->

