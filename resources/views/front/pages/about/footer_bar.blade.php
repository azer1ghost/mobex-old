<div class="row top-50">
    <div class="col-12">
        <div class="blog-post__author">
            <div class="row align-items-center">
                <div class="col-md-3 text-center text-md-left">{!! __('front.about.footer_company_name') !!}</div>
                <div class="col-md-6 text-center"></div>
                <div class="col-md-3 text-center text-md-right">
                    <ul class="socials socials--blue list--reset">
                        @if ($setting->facebook)
                            <li class="socials__item">
                                <a target="_blank" href="{{ $setting->facebook }}"
                                   class="socials__link">
                                    <svg class="icon">
                                        <use xlink:href="#facebook"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                        @if ($setting->twitter)
                            <li class="socials__item">
                                <a target="_blank" href="{{ $setting->twitter }}"
                                   class="socials__link">
                                    <svg class="icon">
                                        <use xlink:href="#twitter"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                        @if ($setting->linkedin)
                            <li class="socials__item">
                                <a target="_blank" href="{{ $setting->linkedin }}"
                                   class="socials__link">
                                    <svg class="icon">
                                        <use xlink:href="#linkedin"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                        @if ($setting->instagram)
                            <li class="socials__item">
                                <a target="_blank" href="{{ $setting->instagram }}"
                                   class="socials__link">
                                    <svg class="icon">
                                        <use xlink:href="#inst"></use>
                                    </svg>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
