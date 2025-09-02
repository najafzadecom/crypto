<footer class="nk-footer bg-theme ov-h">
    <section class="section section-m section-footer tc-light bg-transparent ov-h">
        <div class="container">
            <div class="nk-block block-footer mgb-m30">
                <div class="row justify-content-between">
                    <div class="col-sm-3 mb-sm-0 col-6">
                        <div class="wgs wgs-menu animated" data-animate="fadeInUp" data-delay="0.1">
                            <h6 class="wgs-title">Help</h6>
                            <div class="wgs-body">
                                <ul class="wgs-links">
                                    <li><a href="#">Community</a></li>
                                    <li><a href="#">Knowledge base</a></li>
                                    <li><a href="#">Contact</a></li>
                                    <li><a href="#">Security</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 mb-sm-0 col-6">
                        <div class="wgs wgs-menu animated" data-animate="fadeInUp" data-delay="0.2">
                            <h6 class="wgs-title">Company</h6>
                            <div class="wgs-body">
                                <ul class="wgs-links">
                                    <li><a href="#">About</a></li>
                                    <li><a href="#">Compliance</a></li>
                                    <li><a href="#">Careers</a></li>
                                    <li><a href="#">Blog</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-4 mb-sm-0 col-6">
                        <div class="wgs wgs-menu animated" data-animate="fadeInUp" data-delay="0.3">
                            <h6 class="wgs-title">Products</h6>
                            <div class="wgs-body">
                                <ul class="wgs-links">
                                    <li><a href="#">ICO Crypto Exchange</a></li>
                                    <li><a href="#">Funds Management</a></li>
                                    <li><a href="#">ICO Crypto Extension</a></li>
                                    <li><a href="#">ICO Crypto Mobile</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 mb-sm-0 col-6">
                        <div class="wgs wgs-menu animated" data-animate="fadeInUp" data-delay="0.4">
                            <h6 class="wgs-title">{{ __('Follow') }}</h6>
                            <div class="wgs-body">
                                <ul class="wgs-links">
                                    @if(setting('social_facebook'))
                                        <li>
                                            <a target="_blank" href="{{ setting('social_facebook') }}">
                                                {{ __('Facebook') }}</a>
                                        </li>
                                    @endif
                                    @if(setting('social_x'))
                                        <li>
                                            <a target="_blank" href="{{ setting('social_x') }}">
                                                {{ __('X') }}</a>
                                        </li>
                                    @endif
                                    @if(setting('social_instagram'))
                                        <li>
                                            <a target="_blank" href="{{ setting('social_instagram') }}">
                                                {{ __('Instagram') }}</a>
                                        </li>
                                    @endif
                                    @if(setting('social_tiktok'))
                                        <li>
                                            <a target="_blank" href="{{ setting('social_tiktok') }}">
                                                {{ __('Tiktok') }}</a>
                                        </li>
                                    @endif
                                    @if(setting('social_youtube'))
                                        <li>
                                            <a target="_blank" href="{{ setting('social_youtube') }}">
                                                {{ __('Youtube') }}</a>
                                        </li>
                                    @endif

                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="section section-sm pt-0 footer-bottom animated" data-animate="fadeInUp" data-delay="0.5">
        <div class="container">
            <div class="row justify-content-md-between align-items-center">
                <div class="col-lg-6 col-md-3 col-sm-4">
                    <a href="{{ route('home') }}" class="wgs-logo-s2 d-inline-block mb-2 mb-md-0">
                        <img
                            src="{{ asset('site/assets/images/logo-full-white.png') }}"
                            srcset="{{ asset('site/assets/images/logo-full-white2x.png') }} 2x"
                            alt="logo"
                        >
                    </a>
                </div>
                <div class="col-lg-6 col-md-8">
                    <div class="copyright-text">
                        <ul class="d-flex justify-content-between align-items-center flex-wrap flex-md-nowrap">
                            <li><a href="#">{{ __('Term of Conditions') }}</a></li>
                            <li><a href="#">{{ __('Privacy Policy') }}</a></li>
                            <li><a href="#">{{ __('Cookie Policy') }}</a></li>
                            <li>
                                <p>&copy;{{ date('Y') }} - {{ $site_name }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="nk-ovm shape-z7 ov-h"></div>
</footer>
