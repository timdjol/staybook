
<!DOCTYPE html>
<html lang="ru">

<head>

    <meta charset="utf-8">
    <!-- <base href="/"> -->

    <title>@yield('title') - SilkWayTravel</title>
    <meta name="description" content="">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <!-- Template Basic Images Start -->
    <meta property="og:image" content="path/to/image.jpg">
    <link rel="icon" href="{{route('index')}}/img/favicon.png">
    <link rel="apple-touch-icon" sizes="180x180" href="{{route('index')}}/img/favicon.png">
    <!-- Template Basic Images End -->

    <!-- Custom Browsers Color Start -->
    <meta name="theme-color" content="#000">
    <!-- Custom Browsers Color End -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/gh/eliyantosarage/font-awesome-pro@main/fontawesome-pro-6.5.1-web/css/all.min.css"
          rel="stylesheet">
    <link rel="stylesheet" href="{{route('index')}}/css/main.min.css">
    <link rel="stylesheet" href="{{route('index')}}/css/style.css">


    <script src="{{route('index')}}/js/scripts.min.js"></script>


</head>

<body>
<header>
    <div class="container">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-6">
                <div class="logo">
                    <a href="{{route('homepage')}}"><img src="{{ route('index') }}/img/logo.svg" alt=""></a>
                </div>
            </div>
            <div class="col-lg-10 col-md-8 col-6">
                <ul class="lang d-xl-none d-lg-none d-inline-block">
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
                <nav>
                    <a href="#" class="toggle-mnu d-xl-none d-lg-none"><span></span></a>
                    <ul>
                        <li @routeactive(
                        'homepage')><a href="{{route('index')}}">@lang('main.home')</a></li>
                        <li @routeactive(
                        'hotels')><a href="{{route('hotels')}}">@lang('main.hotels')</a></li>
                        <li @routeactive(
                        'allrooms')><a href="{{route('allrooms')}}">@lang('main.rooms')</a></li>
                        <li @routeactive(
                        'about')><a href="{{route('about')}}">@lang('main.about')</a></li>
                        <li @routeactive(
                        'contactspage')><a href="{{route('contactspage')}}">@lang('main.contacts')
                        </a></li>
                    </ul>
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
                </nav>
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

<footer>
    <div class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-6">
                    <div class="footer-item">
                        <div class="logo"><img src="{{ url('/') }}/img/logo.svg" alt=""></div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4>@lang('main.hotels')</h4>
                        <ul>
                            @foreach($hotels as $hotel)
                                <li><a href="{{ route('hotel', $hotel->code) }}">{{ $hotel->__('title')
                                }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="footer-item">
                        <h4>@lang('main.navigation')</h4>
                        <ul>
                            <li @routeactive(
                            'hotels')><a href="{{route('hotels')}}">@lang('main.hotels')</a></li>
                            <li @routeactive(
                            'allrooms')><a href="{{route('allrooms')}}">@lang('main.rooms')</a></li>
                            <li @routeactive(
                            'about')><a href="{{route('about')}}">@lang('main.about')</a></li>
                            <li @routeactive(
                            'contactspage')><a href="{{route('contactspage')}}">@lang('main.contacts')
                            </a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="footer-item">
                        <h4>@lang('main.contacts')</h4>
                        <ul>
                            <li>{{ $contacts->first()->__('address') }}</li>
                            <li><a href="tel:{{ $contacts->first()->phone }}">{{ $contacts->first()->phone }}</a></li>
                            <li><a href="tel:{{ $contacts->first()->phone2 }}">{{ $contacts->first()->phone2 }}</a></li>
                        </ul>
                        <ul class="soc">
                            <li><a href="{{ $contacts->first()->instagram }}" target="_blank"><img
                                            src="{{route('index')}}/img/instagram.svg" alt=""></a>
                            </li>
                            <li><a href="https://wa.me/{{ $contacts->first()->whatsapp }}" target="_blank"><img
                                            src="{{route('index')}}/img/whatsapp.svg" alt=""></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="copy">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <p>@lang('main.copy') &copy; {{ date('Y') }} staybook.kg</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
    header nav{
        text-align: right;
    }
</style>

</body>

</html>

