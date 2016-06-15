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
                    <li><i class="fa fa-list-alt" aria-hidden="true"></i></li>
                    @if (Auth::check())
                        <li><i class="fa fa-heart" aria-hidden="true"></i></li>
                    @endif
                </ul>

                <ul class="pull-right">
                    <li>
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}"><i class="fa fa-user" aria-hidden="true"></i> {{ trans('pastebin.layout_button_login') }}</a></li>
                            <li><a href="{{ url('/register') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> {{ trans('pastebin.layout_button_register') }}</a></li>
                        @else
                            <li class="navbar-user">
                                <img class="user-avatar" width="22" src="//www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}.jpg" alt="Avatar" />
                                {{ Auth::user()->name }}
                            </li>

                            <div class="pull-right logout-button">
                                <a class="btn btn-danger" href="{{ url('/logout') }}"><i class="fa fa-power-off" aria-hidden="true"></i></a>
                            </div>
                        @endif
                    </li>
                </ul>                
            </div>
        </nav>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">{{ trans('pastebin.toggle_nav') }}</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <div class="brand-logo">
                            <img src="{{ asset('img/logo.png') }}" />  SimPas
                        </div>
                        
                    </a>
                </div>
            </div>
        </nav>

        <div class="container container-space">
            @if(Session::has('flash_message'))
                <div class="alert alert-success">
                    <i class="fa fa-check" aria-hidden="true"></i> {{ Session::get('flash_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                </div>
            @endif

            @if (count($errors))
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <strong>{{ trans('pastebin.error_encountered') }}</strong> {{ $error }}
                    </div>
                @endforeach
            @endif
            @yield('content')
        </div>
    </div>

    <footer>
        <div class="container">
            <div class="pull-right">
                &copy; SimPas Application by Macsch15
            </div>

            <div class="pull-left">
                <a href="#"><i class="fa fa-arrow-up" aria-hidden="true"></i> {{ trans('pastebin.go_top') }}</a>
            </div>
        </div>
    </footer>

    <script src="{{ asset('js/all.js') }}"></script>
    <script>hljs.initHighlightingOnLoad();</script>
    <script>
        $(function () {
            $('[data-toggle=confirmation]').confirmation({
                'title': '<div class="confirmation-text">{{ trans('pastebin.delete_confirmation_text') }}</div>',
                'btnOkLabel': '{{ trans('pastebin.button_confirmation_agree') }}',
                'btnCancelLabel': '{{ trans('pastebin.button_confirmation_no') }}',
                'btnOkClass': 'btn btn-danger',
                'btnCancelClass': 'btn btn-default',
                'popout': true
            });
        });
    </script>
</body>
</html>
