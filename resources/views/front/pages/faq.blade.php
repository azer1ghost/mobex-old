@extends('front.layout')

@section('content')
    <!-- faq-section -->
    <section class="faq-section faq-page-section">
        <div class="auto-container">
            <div class="sec-title  centred">
                <h2>{!! __('front.faq_title') !!}</h2>
            </div>
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 content-column">
                    <div class="content_block_5">
                        <div class="content-box">

                            <ul class="accordion-box">


                                @foreach($faqs as $key => $item)
                                    <li class="accordion block">
                                        <div class="acc-btn">
                                            <div class="icon-outer"></div>
                                            <h4>{!! $item->translateOrDefault($_lang)->question !!}</h4>
                                        </div>
                                        <div class="acc-content">
                                            <div class="text">
                                                <p> {!! $item->translateOrDefault($_lang)->answer !!}</p>
                                            </div>
                                        </div>
                                    </li>

                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- faq-section end --
@endsection