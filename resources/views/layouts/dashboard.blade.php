{{-- Layout per parte degli host nella dashboard --}}
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | Pannello di controllo</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/searchMap.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@3.6.1/dist/chart.min.js"></script>
        
    {{-- Favicon --}}
    <link rel="shortcut icon" href="{{asset('images/favicon.png')}}" type="image/x-icon">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    {{-- Maps TomTom --}}
    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps.css'>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/maps/maps-web.min.js"></script>
    {{-- Services TomTom  --}}
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.15.0/services/services-web.min.js"></script>
    {{-- SearchMap TomTom --}}
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.11/SearchBox-web.js"></script>
    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.11/SearchBox.css'>
    <link rel='stylesheet' type='text/css' href='https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox.css'>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/plugins/SearchBox/3.1.3-public-preview.0/SearchBox-web.js"></script>
    <script src="https://api.tomtom.com/maps-sdk-for-web/cdn/6.x/6.1.2-public-preview.15/services/services-web.min.js"></script>

    {{-- BrainTree --}}
    <script src="https://js.braintreegateway.com/web/dropin/1.32.1/js/dropin.min.js"></script>

</head>
<body onload="searchBox()">
    <nav class="navbar navbar-expand navbar-dark bg-dark flex-md-nowrap py-0 px-4 position-fixed">
        <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="{{route('host.home')}}">
            <img src="{{asset('images/boolbnb-def.png')}}" class="d-none d-md-block" alt="boolbnb_logo">
            <img src="{{asset('images/favicon.png')}}" class="d-block d-md-none" alt="boolbnb_logo">
        </a>
        <ul class="navbar-nav px-3 ml-auto d-flex align-items-center">
            <li class="nav-item my_user">
                <div class="my_user_icon mx-2">
                    <img src="{{asset('images/pippo-avatar.jpg')}}" alt="user_icon">
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="">
                    Bentornato, {{Auth::user()->name}}!
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('index') }}">
                    Visita il sito
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
                    Esci
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-sm-2 col-12 d-md-block my_sidebar bg-dark py-4">
                <ul class="nav d-flex flex-column">
                    <li class="nav-item px-1 " data-toggle='tooltip'  title="Dashboard">
                        <a class="nav-link {{Request::route()->getName()=='host.home'? 'text-light' : null}}" href="{{route('host.home')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                            <span class="d-md-inline-block d-sm-none">Dashboard</span>
                        </a>
                    </li>
                    <li class="nav-item px-1" data-toggle='tooltip' title="I miei appartamenti">
                        <a class="nav-link {{Request::route()->getName()=='host.apartments.index'? 'text-light' : null}}" href="{{route('host.apartments.index')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-list"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                            <span class="d-md-inline-block d-sm-none">Miei Appartamenti</span>
                        </a>
                    </li>
                    <li class="nav-item px-1" data-toggle='tooltip' title="Nuovo Appartamento">
                        <a class="nav-link {{Request::route()->getName()=='host.apartments.create'? 'text-light' : null}}" href="{{route('host.apartments.create')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                            <span class="d-md-inline-block d-sm-none">Nuovo Appartamento</span>
                        </a>
                    </li>
                    <li class="nav-item px-1" data-toggle='tooltip' title="Messaggi">
                        <a class="nav-link {{Request::route()->getName()=='host.messages'? 'text-light' : null}}" href="{{route('host.messages')}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                            <span class="d-md-inline-block d-sm-none">Messaggi</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <main role="main" class="col-md-9 col-sm-10 ml-sm-auto col-lg-9 px-4 py-5">
                @yield('content')
            </main>
        </div>
    </div>
</body>
<style>
@media screen and (max-width: 575px) {

    .navbar .dropdown {
        display: inline-block;
    }

    .navbar-nav li {
        text-align: center;
        
    }    
    
    .my_sidebar{
     height: 70px;
     background-color: #343a40;
     display: flex;
     justify-content: center;
     align-items: center;
    }

    .my_sidebar ul {
        background-color: transparent;
        flex-direction: row !important;
    }

    .my_sidebar ul li{
        
    }
    .my_sidebar ul li a span{
        display: none
    }

    .col-md-10{
        margin-top: 140px;
    }
}
</style>
</html>