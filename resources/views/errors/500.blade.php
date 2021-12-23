@extends('front.layout')

@section('content')
    <section class="error-section centred">
        <div class="auto-container">
            <div class="inner-box">
                <h1>500</h1>
                <h2>Xəta baş verdi</h2>
                <h5 class="mb40" style="margin-bottom: 20px">Hal hazırda sistemdə xəta yaranmışdır. Bir az sonra yenidən cəhd edin.</h5>
                <a href="{{ route('home') }}" class="theme-btn-one"><i class="fas fa-arrow-circle-left"></i>{!! __('front.error.404.back_home') !!}</a>
            </div>
        </div>
    </section>
@endsection