<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ env('APP_NAME') }} @yield('title')</title>

    <!-- Global stylesheets -->
    <link href="{{ asset('admin/assets/fonts/inter/inter.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/icons/phosphor/styles.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/all.min.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <link href="{{ asset('admin/assets/css/custom.css') }}" id="stylesheet" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script src="{{ asset('admin/assets/js/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script src="{{ asset('admin/assets/js/vendor/visualization/d3/d3.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/vendor/visualization/d3/d3_tooltip.js') }}"></script>
    <script src="{{ asset('admin/assets/js/vendor/notifications/sweet_alert.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/vendor/forms/selects/select2.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/vendor/ui/moment/moment.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/vendor/pickers/daterangepicker.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app.js') }}"></script>
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
    <!-- /theme JS files -->
</head>
<body>
@include('admin.parts.navbar')

<div class="page-content">
    @include('admin.parts.sidebar')
    <div class="content-wrapper">
        <div class="content-inner">
            @include('admin.parts.header')
            @yield('content')
            @include('admin.parts.footer')
        </div>
        <div class="btn-to-top" style="">
            <button class="btn btn-secondary btn-icon rounded-pill" type="button"><i class="ph-arrow-up"></i></button>
        </div>
    </div>
</div>


@stack('scripts')
</body>
</html>
