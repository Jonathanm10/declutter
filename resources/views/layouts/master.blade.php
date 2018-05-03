<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <meta name="language" content="{{app()->getLocale()}}"/>
    <meta http-equiv="content-language" content="{{app()->getLocale()}}"/>
    <link rel="stylesheet" href="{{ mix('css/main.css') }}">

    <link rel="shortcut icon" href="/public/favicon.ico"/>

    <title>Declutter - @yield('title')</title>
</head>
<body>
<div class="master">
    @include('structures.navbar')

    <div class="page-content">
        @yield('main')
    </div>

    @include('structures.footer')
</div>

{{-- Render any scripts pushed by the templates --}}
@stack('scripts')
</body>
</html>
