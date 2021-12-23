@extends('front.layout')

@section('content')
    <!-- about-style-two -->
    <section class="about-style-two">
        <div class="auto-container">
            <div class="row align-items-center clearfix">
                <div class="col-lg-<?= ($single->images ? 6 : 12) ?> col-md-12 col-sm-12 content-column">
                    <div class="content_block_1">
                        <div class="content-box mr-50">
                            <div class="sec-title">
                                <p>{!! $single->translateOrDefault($_lang)->title !!}</p>
                            </div>
                            <div class="text">
                                <p> {!! $single->translateOrDefault($_lang)->content !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @if($single->intro_images)
                    <div class="col-lg-6 col-xs-12 col-md-12 col-sm-12 image-column">
                        <div class="image_block_3">
                            <div class="image-box">
                                <div class="pattern">
                                    <div class="pattern-1"
                                         style="background-image: url({{ asset('assets/images/shape/shape-49.png') }});"></div>
                                    <div class="pattern-2"
                                         style="background-image: url({{ asset('assets/images/shape/shape-50.png') }});"></div>
                                    <div class="pattern-3"></div>
                                </div>
                                <figure class="image image-1 paroller"><img src="{{ asset($single->intro_image) }}"
                                                                            alt=""></figure>

                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <script type="application/ld+json">
{
	"@context": "https://schema.org",
	"@type": "BreadcrumbList",
	"itemListElement": [
        {
            "@type": "ListItem",
            "position": 1,
            "name": "{{ __('front.menu.home') }}",
            "item": "{{ route('home') }}"
        },
        {
            "@type": "ListItem",
            "position": 2,
            "name": "{!! __('front.menu.news') !!}",
            "item": "{{ route('news') }}"
        },
        {
            "@type": "ListItem",
            "position": 3,
            "name": "{{ $single->translateOrDefault($_lang)->title }}",
            "item": "{{ URL::current() }}"
        }
	]
}

    </script>
    <script type="application/ld+json">
			{
              "@context": "http://schema.org",
              "@type": "NewsArticle",
              "mainEntityOfPage": {
                "@type": "WebPage",
                "@id": "{{ URL::current() }}"
              },
              "headline": "{{ $single->translateOrDefault($_lang)->title }}",
              "articleBody": "{!! strip_tags($single->translateOrDefault($_lang)->content) !!}",
              "keywords": "",
              "url": "{{ URL::current() }}",
              "articleSection": null,
              "description": "{!! strip_tags($single->meta_description) !!}",
              "author": [
                {
                  "@type": "Organization",
                  "name": "{{ env('APP_NAME') }}"
                }
              ],
              "publisher": {
                "@type": "Organization",
                "name": "{{ env('APP_NAME') }}"
              },
              "image": [
                {
                  "@type": "ImageObject",
                  "url": "{{ asset($single->image) }}"
                }
              ]
            }
    </script>

@endsection

@push('js')
    <script type='text/javascript'
            src='https://platform-api.sharethis.com/js/sharethis.js#property=5f5a765f58adc60012f34323&product=sop'
            async='async'></script>
@endpush