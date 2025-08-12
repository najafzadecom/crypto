<div class="navbar navbar-dark navbar-expand-lg navbar-static border-bottom border-bottom-white border-opacity-10">
    <div class="container-fluid">
        <div class="d-flex d-lg-none me-2">
            <button type="button" class="navbar-toggler sidebar-mobile-main-toggle rounded-pill">
                <i class="ph-list"></i>
            </button>
        </div>

        <div class="navbar-brand flex-1 flex-lg-0">
            <a href="{{ route('admin.dashboard') }}" class="d-inline-flex align-items-center">
                <img src="{{ asset('admin/assets/images/expressbank.png') }}" alt="">
            </a>
        </div>

        <ul class="nav flex-row flex-lg-1 order-2 order-lg-1 ">

        </ul>

        <ul class="nav flex-row justify-content-end order-1 order-lg-2">
            <li class="nav-item ms-lg-2">
                <a href="#" class="navbar-nav-link navbar-nav-link-icon rounded-pill" data-bs-toggle="offcanvas"
                   data-bs-target="#notifications">
                    <i class="ph-bell"></i>
                    <span class="badge bg-yellow text-black position-absolute top-0 end-0 translate-middle-top zindex-1 rounded-pill mt-1 me-1">2</span>
                </a>
            </li>

            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="navbar-nav-link align-items-center rounded-pill p-1" data-bs-toggle="dropdown">
                    <div class="status-indicator-container">
                        <img src="{{ asset('admin/assets/images/demo/users/face1.jpg') }}" class="w-32px h-32px rounded-pill" alt="{{ auth()->user()->name }}">
                        <span class="status-indicator bg-success"></span>
                    </div>
                    <span class="d-none d-lg-inline-block mx-lg-2">{{ auth()->user()->name }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    <a href="{{ route('admin.users.edit', auth()->id()) }}" class="dropdown-item">
                        <i class="ph-gear me-2"></i>
                        {{ __('Account settings') }}
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('admin.auth.logout') }}" class="dropdown-item text-danger">
                        <i class="ph-sign-out me-2"></i>
                        {{ __('Logout') }}
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
