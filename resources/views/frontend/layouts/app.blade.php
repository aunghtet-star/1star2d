<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <!-- Bootstrap core CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Design Bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/css/mdb.min.css" rel="stylesheet">

    {{-- Date ranger picker --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    {{--    Sweet alert 2--}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@5/dark.css" />


    {{-- custom css --}}
    <link rel="stylesheet" href="{{asset('frontend/style.css')}}">

    <style>

        .fa-bell{
                margin-left: 60px;
            }

        @media only screen and (max-width: 600px) {
            .fa-bell{
            margin: 0;
            position: absolute;

            top:19px;
            left: 75%;
            }
        }
    </style>
    @yield('extra_css')
</head>

<body>
   @php
       header('Access-Control-Allow-Headers: *');
   @endphp
    <div id="app mb-4">


        {{-- <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    1Star2dMM
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>


                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a href="{{route('user.two.history')}}">History</a>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav> --}}

        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand text-success font-weight-bold" href="{{url('/')}}">1Star2DMM</a>

                <a class="navbar-brand @if($unread_noti != 0) text-danger @endif"   href="{{url('/notification')}}" ><i class="fas fa-bell "></i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav ml-auto">

                <li class="nav-item mr-3 ">
                    <a class="nav-link" href=""><i class="fas fa-user-circle"></i> @if(Auth::check()) {{ Auth::user()->name }} @endif</a>
                    <a class="nav-link" href="#"><i class="fas fa-coins"></i> @if(Auth::check()) {{ Auth::user()->user_wallet ? number_format(Auth::user()->user_wallet->amount) : '-' }} @endif kyat</a>
                </li>

                <li class="nav-item mr-3 @yield('2d')" >
                  <a class="nav-link" href="{{url('two')}}">Thai 2D</a>
                </li>

                  <li class="nav-item mr-3 @yield('htaitpait')" >
                    <a class="nav-link" href="{{url('two/htaitpait')}}">Thai အမြန်ထိုးရန်</a>
                  </li>

                  <li class="nav-item mr-3 @yield('dubai-2d')" >
                      <a class="nav-link" href="{{url('dubai-two')}}">Dubai 2D</a>
                  </li>

                  <li class="nav-item mr-3 @yield('dubai-htaitpait')" >
                      <a class="nav-link" href="{{url('dubai-two/htaitpait')}}">Dubai အမြန်ထိုးရန်</a>
                  </li>

                <li class="nav-item mr-3 @yield('normal-3d')">
                  <a class="nav-link" href="{{url('normal-three')}}">3D</a>
                </li>

                  <li class="nav-item mr-3 @yield('3d')">
                      <a class="nav-link" href="{{url('three')}}">3D-R</a>
                  </li>

                  <li class="nav-item mr-3 @yield('copy-paste-3d')">
                      <a class="nav-link" href="{{url('copy-paste-three')}}">3D-C</a>
                  </li>

                <li class="nav-item mr-3 @yield('history')">
                    <a class="nav-link" href="{{url('user/history')}}">မှတ်တမ်း</a>
                </li>

                  <li class="nav-item mr-3 @yield('dubai-history')">
                      <a class="nav-link" href="{{url('user/dubai-history')}}">Dubai မှတ်တမ်း</a>
                  </li>

                  <li class="nav-item mr-3 @yield('password-change')">
                      <a class="nav-link" href="{{url('user/password-change')}}">Password ပြောင်းရန်</a>
                  </li>

                <li>
                    <a class="btn btn-sm btn-danger" href="{{ route('logout') }}" onclick="event.preventDefault();
                      if(confirm('သေချာသလား'))
                      document.getElementById('logout-form').submit();">
                    <i class="fas fa-power-off mr-1"></i> ထွက်မည်
                    </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
                </li>
              </ul>
            </div>
            </div>
          </nav>
        <main class="py-4 mb-3">
            @yield('content')
        </main>
    </div>


    <!-- JQuery -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Bootstrap tooltips -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.4/umd/popper.min.js">
    </script>

        <!-- Bootstrap core JavaScript -->
        <script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js"></script>
        <!-- MDB core JavaScript -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.19.1/js/mdb.min.js">
        </script>
    <script src="{{asset('frontend/app.js')}}"></script>

    {{-- sweet alert --}}
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    {{-- js validation --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>

    {{-- InfiniteScroll --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>

    {{-- Date range picker --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script src="{{asset('js/validate.js')}}"></script>


    @yield('scripts')

   <script>

   </script>
</body>

</html>
