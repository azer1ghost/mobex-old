@if(isset($setting))
    <!-- main-footer -->
    <footer class="main-footer dash_footer">
        <div class="footer-top">
            <div class="pattern-layer">
                <div class="pattern-1" style="background-image: url({{ asset('assets/images/shape/shape-30.png') }});"></div>
                <div class="pattern-2" style="background-image: url({{ asset('assets/images/shape/shape-31.png') }});"></div>
            </div>
            <div class="auto-container">
                <div class="widget-section">
                    <div class="row clearfix">
                        <div class="col-lg-4 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget logo-widget">
                                <figure class="footer-logo"><a href="{{ route('home') }}"><img
                                                src="{{ $setting->footer_logo ? asset('uploads/setting/' . $setting->footer_logo) : asset('assets/images/footer-logo.png') }}"
{{--                                                src="{{ asset('assets/images/footer-logo.png') }}" --}}
                                alt=""></a></figure>
                                <div class="text">
                                 {{--   <p>Lorem ipsum is placeholder text commonly used in the graphic, print, and
                                        publishing .</p>--}}
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget links-widget">
                                <div class="widget-title">
                                </div>
                                <div class="widget-content">
                                    <ul class="links clearfix">
                                        <li><a href="{{ route('pages.show','about') }}">{{ __('front.menu.about_us') }}</a></li>
                                        <li><a href="{{ route('shop') }}">{{ __('front.menu.shop') }} </a></li>
                                        <li><a href="{{ route('faq') }}">{{ __('front.menu.faq') }} </a></li>
                                        <li><a href="{{ route('news') }}">{{ __('front.menu.news') }}</a></li>
                                        <li><a href="{{ route('contact') }}">{{ __('front.menu.contact') }} </a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget links-widget">
                                <div class="widget-title">

                                </div>
                                <div class="widget-content">
                                    <ul class="links clearfix">
                                        <li><a href="{{ route('login') }}">  {{ __('front.menu.sign_in') }}</a></li>
                                        <li><a href="{{ route('register') }}">  {{ __('front.menu.sign_up') }}</a></li>
                                        <li><a href="{{ route('pages.show','terms') }}">{{ __('front.menu.terms') }}</a></li>
                                        <li><a href="{{ route('pages.show','privacy') }}">{{ __('front.menu.privacy') }}</a></li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-12 footer-column">
                            <div class="footer-widget contact-widget">
                                <div class="widget-title">

                                </div>
                                <div class="widget-content">
                                    <ul class="info-list clearfix">
                                        <li><i class="fas fa-map-marker-alt"></i>
                                            {{ $setting->address }}
                                        </li>
                                        <li><i class="fas fa-phone"></i>
                                            <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                                        </li>
{{--                                        <li><i class="fab fa-whatsapp"></i><a--}}
{{--                                                    href="https://api.whatsapp.com/send?phone=+994{{ App\Models\Extra\SMS::clearNumber($setting->whatsapp) }}&text=Salam Mobex komandası">{{ $setting->whatsapp }}</a>--}}
{{--                                        </li>--}}
                                        <li><i class="fas fa-envelope"></i>
                                            <a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="auto-container">
                <div class="inner-box clearfix">
                    <div class="copyright pull-left"><p><a href="{{ route('home') }}">{{ env('APP_NAME') }}</a> © {{ date('Y') }} {{ __('front.copyright') }}</p>
                    </div>
                    <ul class="footer-nav pull-right clearfix">
                        @if ($setting->facebook)
                            <li><a target="_blank" href="{{ $setting->facebook }}"><span
                                            class="fab fa-facebook-square"></span></a>
                            </li>
                        @endif
                        @if ($setting->instagram)
                            <li><a target="_blank" href="{{ $setting->instagram }}"><span
                                            class="fab fa-instagram"></span></a>
                            </li>
                        @endif
                        @if ($setting->youtube)
                            <li><a target="_blank" href="{{ $setting->youtube }}"><span class="fab fa-youtube"></span></a>
                            </li>
                        @endif
                        @if ($setting->linkedin)
                            <li><a target="_blank" href="{{ $setting->linkedin }}"><span class="fab fa-linkedin"></span></a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <!-- main-footer end -->

@endif