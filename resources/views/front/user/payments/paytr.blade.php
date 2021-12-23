@extends('front.layout')

@section('content')
    <section class="section dashboard_main_section">
        <div class="container">
            <div class="row">

                <div class="col-lg-12 pr-30">
                    <!-- Ödeme formunun açılması için gereken HTML kodlar / Başlangıç -->
                    <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
                    <iframe src="https://www.paytr.com/odeme/guvenli/<?php echo $token;?>" id="paytriframe"
                            frameborder="0"
                            scrolling="no" style="width: 100%;"></iframe>
                    <script>iFrameResize({}, '#paytriframe');</script>
                    <!-- Ödeme formunun açılması için gereken HTML kodlar / Bitiş -->

                </div>
            </div>
        </div>
    </section>
@endsection