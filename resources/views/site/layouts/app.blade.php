<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="js">
<head>
    <meta charset="utf-8">
    <meta name="author" content="Kamran Najafzade">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <link rel="shortcut icon" href="images/favicon.png">
    <title>@yield('title', '') - {{ config('app.name') }}</title>
    <link rel="stylesheet" href="{{ asset('site/assets/css/vendor.bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('site/assets/css/style-salvia.css') }}" id="changeTheme">
    <link rel="stylesheet" href="{{ asset('site/assets/css/theme.css') }}">
</head>
<body class="nk-body body-wider mode-onepage">
@yield('content')
<div class="preloader preloader-alt no-split">
    <span class="spinner spinner-alt">
        <img class="spinner-brand" src="{{ asset('site/assets/images/logo-full-white.png') }}" alt="">
    </span>
</div>
<script src="{{ asset('site/assets/js/jquery.bundle.js') }}"></script>
<script src="{{ asset('site/assets/js/scripts.js') }}"></script>
<script src="{{ asset('site/assets/js/charts.js') }}"></script>
</body>
</html>
