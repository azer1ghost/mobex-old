@extends('front.layout')

@section('content')

    <!-- about-style-two -->
    <section class="about-style-two">
        <div class="auto-container">
            <div class="row align-items-center clearfix">
                <div class="col-lg-<?= ($page->images ? 6 : 12) ?> col-md-12 col-sm-12 content-column">
                    <div class="content_block_1">
                        <div class="content-box mr-50">
                            <div class="sec-title">
                                <p>{!! $page->translateOrDefault($_lang)->title !!}</p>
                            </div>
                            <div class="text">
                                <p> {!! $page->translateOrDefault($_lang)->content !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if($page->images)
                    <div class="col-lg-6 col-md-12 col-sm-12 image-column">
                        <div class="image_block_3">
                            <div class="image-box">
                                <div class="pattern">
                                    <div class="pattern-1"
                                         style="background-image: url({{ asset('assets/images/shape/shape-49.png') }});"></div>
                                    <div class="pattern-2"
                                         style="background-image: url({{ asset('assets/images/shape/shape-50.png') }});"></div>
                                    <div class="pattern-3"></div>
                                </div>
                                <figure class="image image-1 paroller"><img src="{{ asset($page->image) }}"
                                                                            alt=""></figure>

                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection