<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
            <a class="navbar-brand col-sm-3 col-md-3 mr-0 mw-25 d-none d-md-block" href="/"><img src="{{asset('images/boolbnb-def.png')}}" alt="boolbnb_logo"></a>
            <a class="navbar-brand col-sm-3 col-md-3 mr-0 mw-25 d-block d-md-none" href="/"><img src="{{asset('images/favicon.png')}}" alt="boolbnb_logo"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse col-md-6 col-sm-6 justify-content-center" id="navbarScroll">
            <ul class="navbar-nav mr-2 my-2 my-lg-0 navbar-nav-scroll" style="max-height: 100px;">
            <li class="nav-item {{Request::route()->getName()=='Homepage'? 'active' : 'null'}}">
                <a class="nav-link" href="/">Home</a>
            </li>
            <li class="nav-item {{Request::route()->getName()=='Scopri | BoolBnB'? 'active' : 'null'}}">
                <a class="nav-link" href="/discover">Scopri</a>
            </li>
            <li class="nav-item {{Request::route()->getName()=='Chi siamo | BoolBnB'? 'active' : 'null'}}">
                <a class="nav-link" href="/about">Chi siamo</a>
            </li>

            </ul>
        </div>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav my-background-navbar">
                <!-- Authentication Links -->
                @guest
            <li class="nav-item pr-1 h-50 navbar-buttons">
                <a href="{{route('login')}}" class="button_login p-2 text-decoration-none text-light">
                    Accedi
                </a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item h-50 navbar-buttons mbr-10 margin-bottom-resp">
                    {{-- <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a> --}}
                    <a href="{{route('register')}}" class="button_register p-2 text-decoration-none text-light">
                        Registrati
                    </a>
                </li>
            @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-left" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('host.home') }}">
                            Dashboard
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Esci') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
        <div class="collapse navbar-collapse navbar-hamburger" id="navbarSupportedContent">
            <ul class="navbar-nav my-background-navbar dysplay-none">
                <!-- Authentication Links -->
                @guest
            <li class="nav-item padding-r-10px h-50 navbar-buttons">
                <a href="{{route('login')}}" class="button_login p-2 text-decoration-none text-light">
                    Accedi
                </a>
            </li>
            @if (Route::has('register'))
                <li class="nav-item h-50 navbar-buttons mbr-10">
                    {{-- <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a> --}}
                    <a href="{{route('register')}}" class="button_register p-2 text-decoration-none text-light">
                        Registrati
                    </a>
                </li>
            @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu my-dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('host.home') }}">
                            Dashboard
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                {{ __('Esci') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
                <p class="m-0 border-top-resp pt-1">PAGINE</p>
                <li class="nav-item {{Request::route()->getName()=='Homepage'? 'active' : 'null'}}">
                    <a class="nav-link" href="/">Home</a>
                </li>
                <li class="nav-item {{Request::route()->getName()=='Scopri | BoolBnB'? 'active' : 'null'}}">
                    <a class="nav-link" href="/discover">Scopri</a>
                </li>
                <li class="nav-item {{Request::route()->getName()=='Chi siamo | BoolBnB'? 'active' : 'null'}}">
                    <a class="nav-link" href="/about">Chi siamo</a>
                </li>
            </ul>
        </div>
    </div>
</nav>