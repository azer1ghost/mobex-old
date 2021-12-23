@extends('front.layout')

@section('content')
    <section class="section blog">
        <div class="row bottom-70">
            <div class="col-12">
                <div class="heading heading--center"><span
                            class="heading__pre-title">{!! __('front.services.title') !!}</span>
                    <h3 class="heading__title">{!! __('front.services.sub_title') !!}</h3>
                </div>
            </div>
        </div>
        <div class="container">

            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="row">
                        @foreach($services as $service)
                            <div class="col-md-6 col-xl-4">
                                <div class="blog-item">
                                    <a href="#!">
                                        <div class="blog-item__img"><img class="img--bg"
                                                                         src="{{ asset($service->image) }}"
                                                                         alt="img"/></div>
                                    </a>
                                    <h6 class="blog-item__title"><a href="#!">{!! $service->translateOrDefault($_lang)->name !!}</a></h6>
                                    <div class="blog-item__text">
                                        {!! $service->translateOrDefault($_lang)->description !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection