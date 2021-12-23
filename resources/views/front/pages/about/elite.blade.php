@extends('front.layout')

@section('content')

    <section class="section faq pt-200">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-12"><img class="blog-post__img" src="{{ asset('front/img/about.jpg') }}"
                                                 alt="img"/>
                            <h4 class="blog-post__title">{!! __('front.elite.title') !!}</h4>
                            {!! __('front.elite.body') !!}
                        </div>
                    </div>
                    @include('front.pages.about.footer_bar')
                </div>
            </div>
        </div>
    </section>
@endsection