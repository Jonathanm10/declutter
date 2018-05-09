<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
    <meta name="language" content="{{app()->getLocale()}}"/>
    <meta http-equiv="content-language" content="{{app()->getLocale()}}"/>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <link rel="shortcut icon" href="/public/favicon.ico"/>

    <title>Declutter - @yield('title')</title>
</head>
<body>
@include('structures.topbar')

<div class="container-fluid">
    <div class="row">
        @include('structures.navbar')

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="flash-message">
                @foreach (['danger', 'success'] as $msg)
                    @if(Session::has($msg))
                        <div class="alert alert-{{ $msg }} alert-dismissible fade show" role="alert">
                            {{ Session::get($msg) }}
                        </div>
                    @endif
                @endforeach
            </div>

            @yield('main')
        </main>
    </div>
</div>

@include('structures.footer')

{{-- Render any scripts pushed by the templates --}}
@stack('scripts')
</body>
</html>
