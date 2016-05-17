<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('pastebin.title') }}</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrap">
        <nav class="navbar-top">
            <div class="container">
                <ul>
                    <li><i class="fa fa-home"></i></li>
                    <li><i class="fa fa-asterisk"></i></li>
                    <li><i class="fa fa-bookmark"></i></li>
                    <li><i class="fa fa fa-bars"></i></li>
                </ul>

                <ul class="pull-right">
                    <li><i class="fa fa-home"></i></li>
                    <li><i class="fa fa-asterisk"></i></li>
                    <li><i class="fa fa-bookmark"></i></li>
                    <li><i class="fa fa fa-bars"></i></li>
                </ul>                
            </div>
        </nav>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <div class="brand-logo">
                            &lt; /&gt; 
                        </div>
                        SimPas
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li class="navbar-user">
                                <img class="user-avatar" width="22" src="//www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}.jpg" alt="Avatar" />
                                {{ Auth::user()->name }}
                            </li>

                            <div class="pull-right logout-button">
                                <a class="btn btn-danger" href="{{ url('/logout') }}"><i class="fa fa-power-off" aria-hidden="true"></i></a>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container container-space">
            @yield('content')
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="pull-right">
                &copy; SimPas Application by Macsch15
            </div>

            <div class="pull-left">
                <a href="#"><i class="fa fa-arrow-up"></i> Go to top</a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/all.js') }}"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <script>
        $(function () {
            $('[data-toggle=confirmation]').confirmation({
                'title': '<div class="confirmation-text">Are you sure?</div>',
                'btnOkLabel': 'Yup',
                'btnCancelLabel': 'NOOO!',
                'btnOkClass': 'btn btn-danger',
                'btnCancelClass': 'btn btn-default',
                'popout': true
            });
        });
    </script>
</body>
</html>
