<header class="nk-header page-header is-transparent is-sticky is-shrink is-split" id="header">
    <div class="header-main">
        <div class="container container-xxl">
            <div class="header-wrap">
                <div class="header-logo logo animated" data-animate="fadeInDown" data-delay=".65">
                    <a href="{{ localizedRoute('home') }}" class="logo-link">
                        <img
                            class="logo-dark"
                            src="{{ asset('site/assets/images/logo.png') }}"
                            srcset="{{ asset('site/assets/images/logo2x.png') }} 2x"
                            alt="logo"
                        >
                        <img
                            class="logo-light"
                            src="{{ asset('site/assets/images/logo-full-white.png') }}"
                            srcset="{{ asset('site/assets/images/logo-full-white2x.png') }} 2x" alt="logo">
                    </a>
                </div>
                <div class="header-nav-toggle">
                    <a href="#" class="navbar-toggle" data-menu-toggle="header-menu">
                        <div class="toggle-line"><span></span></div>
                    </a>
                </div>
                <div class="header-navbar header-navbar-s2 flex-grow-1 animated" data-animate="fadeInDown"
                     data-delay=".75">
                    <nav class="header-menu header-menu-s2" id="header-menu">
                        @if($headerMenu && $headerMenu->menuItems())
                            <ul class="menu mx-auto">
                                @foreach($headerMenu->menuItems() as $menuItem)
                                    <li class="menu-item @if($menuItem->children) has-sub @endif">
                                        <a class="menu-link nav-link menu-toggle" href="@if($menuItem->children)#@else {{ $menuItem->translation->link }} @endif">{{ $menuItem->translation->name }}</a>
                                        @if($menuItem->children)
                                        <div class="menu-sub menu-drop menu-mega menu-mega-3clmn">
                                            <div class="menu-mega-innr">
                                                <ul class="menu-mega-list">
                                                    <li class="menu-item">
                                                        <a href="{{ $menuItem->translation->link }}">{{ $menuItem->translation->name }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                        <ul class="menu-btns">
                            <li>
                                <a href="{{ localizedRoute('register') }}" class="btn btn-md btn-auto btn-secondary btn-outline no-change">
                                    <span>{{ __('Sign Up') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ localizedRoute('login') }}" class="btn btn-md btn-auto btn-secondary no-change focus">
                                    <span>{{ __('Login') }}</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</header>
