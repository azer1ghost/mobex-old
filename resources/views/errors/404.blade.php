@extends('front.layout')

@section('content')
    <section class="error-section centred">
        <div class="auto-container">
            <div class="inner-box">
                <h1>404</h1>
                <h2>{!! __('front.error.404.title') !!}</h2>
                <a href="{{ route('home') }}" class="theme-btn-one"><i class="fas fa-arrow-circle-left"></i>{!! __('front.error.404.back_home') !!}</a>
            </div>
        </div>
    </section>
@endsection