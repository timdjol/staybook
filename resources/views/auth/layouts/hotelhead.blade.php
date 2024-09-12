<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <!-- <base href="/"> -->

    <title>@yield('title') - StayBook</title>
    <meta name="description" content="">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Template Basic Images Start -->
    <meta property="og:image" content="path/to/image.jpg">
    <link rel="icon" href="{{route('index')}}/img/favicon/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="{{route('index')}}/img/favicon/apple-touch-icon-180x180.png">
    <!-- Template Basic Images End -->

    <!-- Custom Browser Color Start -->
    <meta name="theme-color" content="#000">
    <!-- Custom Browsers Color End -->

    <link rel="stylesheet" href="{{route('index')}}/css/main.min.css">
    <link rel="stylesheet" href="{{route('index')}}/css/admin.css">
    <link href="{{route('index')}}/css/print.css" rel="stylesheet" media="print" type="text/css">

</head>

<body>
<header>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="logo">
                    <a href="{{route('hotels.index')}}"><img src="https://silkway.timmedia.store/img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-md-6">
                <ul class="lang d-xl-inline-block d-lg-inline-block d-none">
                    <li class="
                            @if(session('locale')=='ru')
                                current
                            @endif
                            "><a href="{{ route('locale', 'ru') }}">RU</a></li>
                    <li class="
                            @if(session('locale')=='en')
                                current
                            @endif
                            "><a href="{{ route('locale', 'en') }}">EN</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <div class="homelink">
                    <a href="{{route('homepage')}}" target="_blank"><i class="fas fa-house"></i> @lang('admin.visit')</a>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('success'))
                <p class="alert alert-success">{{ session()->get('success') }}</p>
            @endif
            @if(session()->has('warning'))
                <p class="alert alert-warning">{{ session()->get('warning') }}</p>
            @endif
        </div>
    </div>
</div>
@yield('content')

{{--<footer>--}}
{{--    <div class="copy">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col-md-12">--}}
{{--                    <p>@lang('main.copy') &copy; {{ date('Y') }} StayBook</p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</footer>--}}

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    $(function() {
        $('#dynamic_select').on('change', function() {
            let url = $(this).val();
            if (url) {
                window.location = url;
            }
            return false;
        });
    });
</script>

</body>
</html>

