@if(isset($setting))
    <!-- Mobile Menu  -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <div class="close-btn"><i class="fas fa-times"></i></div>

        <nav class="menu-box">
            <div class="nav-logo"><a href="{{ route('home') }}"> <img
                            src="{{ $setting->footer_logo ? asset('uploads/setting/' . $setting->footer_logo) : asset('assets/images/footer-logo.png') }}"
                            alt="{{ env('APP_NAME') }}"></a></div>
            <div class="menu-outer">
                <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header--></div>
            <div class="contact-info">
                <h4>{{ __('front.menu.contact') }}</h4>
                <ul>
                    <li> {{ $setting->address }}</li>
                    <li>
                        <a href="tel:{{ $setting->phone }}">{{ $setting->phone }}</a>
                    </li>
                    <li><i class="fab fa-whatsapp"></i><a
                                href="https://api.whatsapp.com/send?phone=+994{{ App\Models\Extra\SMS::clearNumber($setting->whatsapp) }}&text=Salam Mobex komandası">&nbsp;{{ $setting->whatsapp }}</a>
                    </li>
                    <li><a href="mailto:{{ $setting->email }}">{{ $setting->email }}</a></li>
                </ul>
            </div>
            <div class="social-links">
                <ul class="clearfix">
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
        </nav>
    </div><!-- End Mobile Menu -->
@endif