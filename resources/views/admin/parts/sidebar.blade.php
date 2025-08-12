<div class="sidebar sidebar-dark sidebar-main sidebar-expand-lg">
    <div class="sidebar-content">
        <div class="sidebar-section">
            <div class="sidebar-section-body d-flex justify-content-center">
                <h5 class="sidebar-resize-hide flex-grow-1 my-auto">{{ __('Navigation') }}</h5>

                <div>
                    <button type="button"
                            class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                        <i class="ph-arrows-left-right"></i>
                    </button>

                    <button type="button"
                            class="btn btn-flat-white btn-icon btn-sm rounded-pill border-transparent sidebar-mobile-main-toggle d-lg-none">
                        <i class="ph-x"></i>
                    </button>
                </div>
            </div>
        </div>

        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                <li class="nav-item-header pt-0">
                    <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">{{ __('Main') }}</div>
                    <i class="ph-dots-three sidebar-resize-show"></i>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link @if(request()->routeIs('admin.dashboard')) active @endif">
                        <i class="ph-house"></i>
                        <span>{{ __('Dashboard') }}</span>
                    </a>
                </li>

                @canany(['users-index', 'roles-index', 'permissions-index'])
                    <!-- Access Management -->
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">{{ __('Access Management') }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    @can('users-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.users.index') }}"
                               class="nav-link @if(request()->routeIs('admin.users.*')) active @endif">
                                <i class="ph-user-circle"></i>
                                <span>{{ __('Users') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('roles-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.roles.index') }}"
                               class="nav-link @if(request()->routeIs('admin.roles.*')) active @endif">
                                <i class="ph-users-three"></i>
                                <span>{{ __('Roles') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('permissions-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.permissions.index') }}"
                               class="nav-link @if(request()->routeIs('admin.permissions.*')) active @endif">
                                <i class="ph-lock-key"></i>
                                <span>{{ __('Permissions') }}</span>
                            </a>
                        </li>
                    @endcan
                @endcanany

                @canany(['categories-index', 'languages-index', 'news-index', 'pages-index', 'faqs-index'])
                    <!-- Content Management -->
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">{{ __('Content Management') }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    @can('categories-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.categories.index') }}"
                               class="nav-link @if(request()->routeIs('admin.categories.*')) active @endif">
                                <i class="ph-folder"></i>
                                <span>{{ __('Categories') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('languages-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.languages.index') }}"
                               class="nav-link @if(request()->routeIs('admin.languages.*')) active @endif">
                                <i class="ph-globe"></i>
                                <span>{{ __('Languages') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('news-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.news.index') }}"
                               class="nav-link @if(request()->routeIs('admin.news.*')) active @endif">
                                <i class="ph-newspaper"></i>
                                <span>{{ __('News') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('pages-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.pages.index') }}"
                               class="nav-link @if(request()->routeIs('admin.pages.*')) active @endif">
                                <i class="ph-file-text"></i>
                                <span>{{ __('Pages') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('faqs-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.faqs.index') }}"
                               class="nav-link @if(request()->routeIs('admin.faqs.*')) active @endif">
                                <i class="ph-question"></i>
                                <span>{{ __('FAQs') }}</span>
                            </a>
                        </li>
                    @endcan
                @endcanany

                @canany(['menus-index', 'menu-items-index', 'sliders-index', 'static-blocks-index', 'testimonials-index'])
                    <!-- Website Management -->
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">{{ __('Website Management') }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    @can('menus-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.menus.index') }}"
                               class="nav-link @if(request()->routeIs('admin.menus.*')) active @endif">
                                <i class="ph-list"></i>
                                <span>{{ __('Menus') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('menu-items-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.menu-items.index') }}"
                               class="nav-link @if(request()->routeIs('admin.menu-items.*')) active @endif">
                                <i class="ph-list-dashes"></i>
                                <span>{{ __('Menu Items') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('sliders-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.sliders.index') }}"
                               class="nav-link @if(request()->routeIs('admin.sliders.*')) active @endif">
                                <i class="ph-images"></i>
                                <span>{{ __('Sliders') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('static-blocks-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.static-blocks.index') }}"
                               class="nav-link @if(request()->routeIs('admin.static-blocks.*')) active @endif">
                                <i class="ph-squares-four"></i>
                                <span>{{ __('Static Blocks') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('testimonials-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.testimonials.index') }}"
                               class="nav-link @if(request()->routeIs('admin.testimonials.*')) active @endif">
                                <i class="ph-chat-circle"></i>
                                <span>{{ __('Testimonials') }}</span>
                            </a>
                        </li>
                    @endcan
                @endcanany

                @canany(['packages-index', 'orders-index', 'transactions-index'])
                    <!-- Business Management -->
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">{{ __('Business Management') }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    @can('packages-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.packages.index') }}"
                               class="nav-link @if(request()->routeIs('admin.packages.*')) active @endif">
                                <i class="ph-package"></i>
                                <span>{{ __('Packages') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('orders-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.orders.index') }}"
                               class="nav-link @if(request()->routeIs('admin.orders.*')) active @endif">
                                <i class="ph-shopping-cart"></i>
                                <span>{{ __('Orders') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('transactions-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.transactions.index') }}"
                               class="nav-link @if(request()->routeIs('admin.transactions.*')) active @endif">
                                <i class="ph-coins"></i>
                                <span>{{ __('Transactions') }}</span>
                            </a>
                        </li>
                    @endcan
                @endcanany

                @canany(['settings-index', 'activity-logs-index'])
                    <!-- System -->
                    <li class="nav-item-header">
                        <div class="text-uppercase fs-sm lh-sm opacity-50 sidebar-resize-hide">{{ __('System') }}</div>
                        <i class="ph-dots-three sidebar-resize-show"></i>
                    </li>
                    @can('activity-logs-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.activity-logs.index') }}"
                               class="nav-link @if(request()->routeIs('admin.activity-logs.*')) active @endif">
                                <i class="ph-list-checks"></i>
                                <span>{{ __('Activity Logs') }}</span>
                            </a>
                        </li>
                    @endcan
                    @can('settings-index')
                        <li class="nav-item">
                            <a href="{{ route('admin.settings.index') }}"
                               class="nav-link @if(request()->routeIs('admin.settings.*')) active @endif">
                                <i class="ph-gear"></i>
                                <span>{{ __('Settings') }}</span>
                            </a>
                        </li>
                    @endcan
                @endcanany
            </ul>
        </div>
    </div>
</div>