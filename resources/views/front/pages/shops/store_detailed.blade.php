@extends('front.layout')

@section('content')
    <section class="section shop-product pt-200 pb-0">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-md-2 col-lg-6 offset-lg-0">
                    <!-- dual slider start-->
                    <div class="dual-slider">
                        <div class="main-slider">
                            <div class="main-slider__item">
                                <div class="main-slider__img"><img class="img--contain" src="img/b_1.jpg" alt="single"/>
                                </div>
                            </div>
                            <div class="main-slider__item">
                                <div class="main-slider__img"><img class="img--contain" src="img/b_2.jpg" alt="single"/>
                                </div>
                            </div>
                            <div class="main-slider__item">
                                <div class="main-slider__img"><img class="img--contain" src="img/b_3.jpg" alt="single"/>
                                </div>
                            </div>
                            <div class="main-slider__item">
                                <div class="main-slider__img"><img class="img--contain" src="img/b_4.jpg" alt="single"/>
                                </div>
                            </div>
                        </div>
                        <div class="nav-slider">
                            <div class="nav-slider__item">
                                <div class="nav-slider__img"><img class="img--contain" src="img/s_1.jpg" alt="single"/>
                                </div>
                            </div>
                            <div class="nav-slider__item">
                                <div class="nav-slider__img"><img class="img--contain" src="img/s_2.jpg" alt="single"/>
                                </div>
                            </div>
                            <div class="nav-slider__item">
                                <div class="nav-slider__img"><img class="img--contain" src="img/s_3.jpg" alt="single"/>
                                </div>
                            </div>
                            <div class="nav-slider__item">
                                <div class="nav-slider__img"><img class="img--contain" src="img/s_4.jpg" alt="single"/>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- dual slider end-->
                </div>
                <div class="col-lg-6">
                    <div class="shop-product__top">
                        <h3 class="shop-product__name">Delivery box small</h3>
                        <s class="shop-product__old-price">$16.00</s><span class="shop-product__price">$14.00</span>
                        <div class="shop-product__rating">
                            <ul class="rating-list">
                                <li class="rating-list__item">
                                    <svg class="icon">
                                        <use xlink:href="#star"></use>
                                    </svg>
                                </li>
                                <li class="rating-list__item">
                                    <svg class="icon">
                                        <use xlink:href="#star"></use>
                                    </svg>
                                </li>
                                <li class="rating-list__item">
                                    <svg class="icon">
                                        <use xlink:href="#star"></use>
                                    </svg>
                                </li>
                                <li class="rating-list__item">
                                    <svg class="icon">
                                        <use xlink:href="#star"></use>
                                    </svg>
                                </li>
                                <li class="rating-list__item">
                                    <svg class="icon">
                                        <use xlink:href="#star"></use>
                                    </svg>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="shop-product__description">
                        <p>Tench South American darter bobtail snipe eel armored searobin lumpsucker combfish flat loach
                            tang píntano spiderfish gunnel. Skilfish, halosaur skilfish manefish, bonnetmouth alfonsino
                            largenose</p>
                        <ul class="shop-product__list list--reset">
                            <li><span>SKU:</span> <span>68</span></li>
                            <li><span>Category:</span> <span>Transport</span></li>
                            <li><span>Tags:</span> <a class="tag" href="#">#Transport</a> <a class="tag" href="#">#Business</a>
                                <a class="tag" href="#">#Warehouse</a></li>
                        </ul>
                    </div>
                    <form class="form product-form" action="javascript:void(0);" autocomplete="off">
                        <div class="form__count"><span class="form__minus"></span>
                            <input class="form__field" type="number" value="1"/><span class="form__plus"></span>
                        </div>
                        <div class="product-form__favorite">
                            <svg class="icon">
                                <use xlink:href="#heart"></use>
                            </svg>
                        </div>
                        <button class="button button--green" type="submit"><span>Purchase</span>
                            <svg class="icon">
                                <use xlink:href="#arrow"></use>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 col-xl-9">
                    <div class="tabs horizontal-tabs shop-product__tabs">
                        <ul class="horizontal-tabs__header">
                            <li><a href="#horizontal-tabs__item-1"><span>Description</span></a></li>
                            <li><a href="#horizontal-tabs__item-2"><span>Reviews <span>(1)</span></span></a></li>
                        </ul>
                        <div class="horizontal-tabs__content">
                            <div class="horizontal-tabs__item" id="horizontal-tabs__item-1">
                                <p><strong>Trumpeter ropefish bonito roughy cobbler dogteeth tetra sturgeon pollock sea
                                        snail, saury woody sculpin southern sandfish blue.</strong></p>
                                <p>Tench South American darter bobtail snipe eel armored searobin lumpsucker combfish
                                    flat loach tang píntano spiderfish gunnel. Skilfish, halosaur skilfish manefish,
                                    bonnetmouth alfonsino largenose fish moonfish aruana glowlight danio. Basking shark
                                    halibut, North Pacific daggertooth, bonnetmouth sand stargazer sand goby. Queen
                                    triggerfish sand dab hammerhead shark zebra trout pelican gulper, common tunny
                                    boarfish. Pleco riffle dace flier trunkfish</p>
                            </div>
                            <div class="horizontal-tabs__item" id="horizontal-tabs__item-2">
                                <h5 class="tabs__title">1 Review for Delivery box small</h5>
                                <div class="comments top-20">
                                    <div class="comments__item">
                                        <div class="comments__item-img"><img class="img--bg" src="img/author_1.png"
                                                                             alt="img"/></div>
                                        <div class="comments__item-description">
                                            <div class="row align-items-center">
                                                <div class="col-12 bottom-10">
                                                    <ul class="rating-list">
                                                        <li class="rating-list__item">
                                                            <svg class="icon">
                                                                <use xlink:href="#star"></use>
                                                            </svg>
                                                        </li>
                                                        <li class="rating-list__item">
                                                            <svg class="icon">
                                                                <use xlink:href="#star"></use>
                                                            </svg>
                                                        </li>
                                                        <li class="rating-list__item">
                                                            <svg class="icon">
                                                                <use xlink:href="#star"></use>
                                                            </svg>
                                                        </li>
                                                        <li class="rating-list__item">
                                                            <svg class="icon">
                                                                <use xlink:href="#star"></use>
                                                            </svg>
                                                        </li>
                                                        <li class="rating-list__item">
                                                            <svg class="icon">
                                                                <use xlink:href="#star"></use>
                                                            </svg>
                                                        </li>
                                                    </ul>
                                                </div>
                                                <div class="col-6"><span
                                                            class="comments__item-name">Stevie Wonder</span></div>
                                                <div class="col-6 text-right"><span class="comments__item-action">
																<svg class="icon">
																	<use xlink:href="#previous"></use>
																</svg></span></div>
                                                <div class="col-12">
                                                    <div class="comments__item-text">
                                                        <p>Grande perch speckled trout! Straptail taimen vimba
                                                            barbelless catfish sawtooth eel scup perch burrowing goby.
                                                            Siamese fighting fish Devario dogfish</p><span
                                                                class="comments__item-date">2 December 2019</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <form class="form comments-form" action="javascript:void(0);">
                                    <div class="row">
                                        <div class="col-12">
                                            <h5 class="comments-form__title">Your comment</h5>
                                        </div>
                                        <div class="col-12">
                                            <div class="form__rating">
                                                <input class="form__rating-input" id="rate_0" type="radio" name="rating"
                                                       value="0" disabled="disabled"/>
                                                <label class="form__rating-label" for="rate_1">
                                                    <svg class="icon">
                                                        <use xlink:href="#star"></use>
                                                    </svg>
                                                </label>
                                                <input class="form__rating-input" id="rate_1" type="radio" name="rating"
                                                       value="1" checked="checked"/>
                                                <label class="form__rating-label" for="rate_2">
                                                    <svg class="icon">
                                                        <use xlink:href="#star"></use>
                                                    </svg>
                                                </label>
                                                <input class="form__rating-input" id="rate_2" type="radio" name="rating"
                                                       value="2"/>
                                                <label class="form__rating-label" for="rate_3">
                                                    <svg class="icon">
                                                        <use xlink:href="#star"></use>
                                                    </svg>
                                                </label>
                                                <input class="form__rating-input" id="rate_3" type="radio" name="rating"
                                                       value="3"/>
                                                <label class="form__rating-label" for="rate_4">
                                                    <svg class="icon">
                                                        <use xlink:href="#star"></use>
                                                    </svg>
                                                </label>
                                                <input class="form__rating-input" id="rate_4" type="radio" name="rating"
                                                       value="4"/>
                                                <label class="form__rating-label" for="rate_5">
                                                    <svg class="icon">
                                                        <use xlink:href="#star"></use>
                                                    </svg>
                                                </label>
                                                <input class="form__rating-input" id="rate_5" type="radio" name="rating"
                                                       value="5"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <textarea class="form__field form__message" name="message"
                                                      placeholder="Message"></textarea>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form__field" type="text" name="name" placeholder="Your Name"/>
                                        </div>
                                        <div class="col-md-6">
                                            <input class="form__field" type="email" name="email"
                                                   placeholder="Your Email"/>
                                        </div>
                                        <div class="col-12 bottom-40">
                                            <label class="form__checkbox-label"><span class="form__label-text">Save my name, email, and website in this browser for the next time I comment.</span>
                                                <input class="form__input-checkbox" type="checkbox" name="size-select"
                                                       value="Size S"/><span class="form__checkbox-mask"></span>
                                            </label>
                                        </div>
                                        <div class="col-12">
                                            <button class="button button--green" type="submit"><span>Submit</span>
                                                <svg class="icon">
                                                    <use xlink:href="#arrow"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- shop product end-->
    <!-- section start-->
    <section class="section">
        <div class="container">
            <div class="row bottom-70">
                <div class="col-12">
                    <div class="heading"><span class="heading__pre-title">best sellers</span>
                        <h3 class="heading__title">Best sellers products</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="bests-slider">
                        <div class="bests-slider__item">
                            <div class="shop-item text-center">
                                <div class="shop-item__favorite">
                                    <svg class="icon">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </div>
                                <div class="shop-item__badge badge--sale">Sale</div>
                                <div class="shop-item__img"><img class="img--contain" src="img/shop_1.jpg" alt="img"/>
                                </div>
                                <h6 class="shop-item__title"><a href="#">Delivery box small</a></h6>
                                <div class="shop-item__price">
                                    <s>$16.00</s><span>$14.00</span>
                                </div>
                                <ul class="rating-list justify-content-center">
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item rating-list__item--disabled">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                </ul>
                                <a class="button button--green" href="#"><span>Add to cart</span>
                                    <svg class="icon">
                                        <use xlink:href="#bag"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="bests-slider__item">
                            <div class="shop-item text-center">
                                <div class="shop-item__favorite">
                                    <svg class="icon">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </div>
                                <div class="shop-item__img"><img class="img--contain" src="img/shop_2.jpg" alt="img"/>
                                </div>
                                <h6 class="shop-item__title"><a href="#">Delivery box big</a></h6>
                                <div class="shop-item__price"><span>$16.00</span></div>
                                <ul class="rating-list justify-content-center">
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item rating-list__item--disabled">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                </ul>
                                <a class="button button--green" href="#"><span>Add to cart</span>
                                    <svg class="icon">
                                        <use xlink:href="#bag"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="bests-slider__item">
                            <div class="shop-item text-center">
                                <div class="shop-item__favorite">
                                    <svg class="icon">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </div>
                                <div class="shop-item__img"><img class="img--contain" src="img/shop_3.jpg" alt="img"/>
                                </div>
                                <h6 class="shop-item__title"><a href="#">Delivery box</a></h6>
                                <div class="shop-item__price"><span>$18.00</span></div>
                                <ul class="rating-list justify-content-center">
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item rating-list__item--disabled">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                </ul>
                                <a class="button button--green" href="#"><span>Add to cart</span>
                                    <svg class="icon">
                                        <use xlink:href="#bag"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="bests-slider__item">
                            <div class="shop-item text-center">
                                <div class="shop-item__favorite">
                                    <svg class="icon">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </div>
                                <div class="shop-item__img"><img class="img--contain" src="img/shop-5.jpg" alt="img"/>
                                </div>
                                <h6 class="shop-item__title"><a href="#">Delivery box medium</a></h6>
                                <div class="shop-item__price"><span>$18.00</span></div>
                                <ul class="rating-list justify-content-center">
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item rating-list__item--disabled">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                </ul>
                                <a class="button button--green" href="#"><span>Add to cart</span>
                                    <svg class="icon">
                                        <use xlink:href="#bag"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="bests-slider__item">
                            <div class="shop-item text-center">
                                <div class="shop-item__favorite">
                                    <svg class="icon">
                                        <use xlink:href="#heart"></use>
                                    </svg>
                                </div>
                                <div class="shop-item__badge badge--new">New</div>
                                <div class="shop-item__img"><img class="img--contain" src="img/shop_4.jpg" alt="img"/>
                                </div>
                                <h6 class="shop-item__title"><a href="#">Delivery box</a></h6>
                                <div class="shop-item__price"><span>$16.00</span></div>
                                <ul class="rating-list justify-content-center">
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                    <li class="rating-list__item rating-list__item--disabled">
                                        <svg class="icon">
                                            <use xlink:href="#star"></use>
                                        </svg>
                                    </li>
                                </ul>
                                <a class="button button--green" href="#"><span>Add to cart</span>
                                    <svg class="icon">
                                        <use xlink:href="#bag"></use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="bests-slider__nav"></div>
                </div>
            </div>
        </div>
    </section>

@endsection