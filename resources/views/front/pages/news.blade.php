@extends('front.layout')

@section('content')

    <!-- news-section -->
    <section class="blog-grid">
        <div class="auto-container">
            <div class="row clearfix">
                @foreach($news as $post)
                    <div class="col-lg-4 col-md-6 col-sm-12 news-block">
                        <div class="news-block-one wow fadeInUp animated animated" data-wow-delay="00ms"
                             data-wow-duration="1500ms">
                            <div class="inner-box">
                                <figure class="image-box">
                                    <img src="{{ asset($post->image) }}" alt="{!! $post->translateOrDefault($_lang)->title !!}">
                                </figure>
                                <div class="lower-content">
                                    <h3>  <a title="{!! $post->translateOrDefault($_lang)->title !!}"
                                             href="{{ route('news.show', $post->slug) }}">{!! $post->translateOrDefault($_lang)->title !!}</a></h3>
                                    <ul class="post-info">

                                        <li>{!! $post->created_at->format('M d,Y') !!}</li>
                                    </ul>
                                    <p>{!! cutWords($post->translateOrDefault($_lang)->content) !!}</p>
                                    <div class="link">  <a title="{!! $post->translateOrDefault($_lang)->title !!}"
                                                           href="{{ route('news.show', $post->slug) }}"><i class="icon-Arrow-Right"></i></a></div>
                                    <div class="btn-box">  <a title="{!! $post->translateOrDefault($_lang)->title !!}"
                                                              href="{{ route('news.show', $post->slug) }}" class="theme-btn-one">{{ __('front.read_more') }}<i
                                                    class="icon-Arrow-Right"></i></a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="pagination-wrapper centred">
                @include('front.widgets.pagination', ['paginator' => $news])
            </div>
        </div>
    </section>
    <!-- news-section end -->
@endsection