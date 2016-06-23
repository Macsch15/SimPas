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
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="{{ url('/') }}">
                        <div class="brand-logo">
                            SimPas
                        </div>
                    </a>   

                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#user-responsive">
                        <span class="sr-only">{{ trans('pastebin.toggle_nav') }}</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>                 
                </div>

                <div id="user-responsive" class="pull-right collapse navbar-collapse">
                    @if (Auth::guest())
                        <div class="navbar-guest">
                            <a class="btn btn-link" href="{{ url('/login') }}"><i class="fa fa-user" aria-hidden="true"></i> {{ trans('pastebin.layout_button_login') }}</a>
                            <a class="btn btn-link" href="{{ url('/register') }}"><i class="fa fa-sign-in" aria-hidden="true"></i> {{ trans('pastebin.layout_button_register') }}</a>
                        </div>
                    @else
                        <div class="navbar-user">
                            <img class="user-avatar" width="30" src="//www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}.jpg" alt="Avatar" />
                            {{ Auth::user()->name }}

                            <div class="pull-right logout-button">
                                <a class="btn btn-link" href="{{ url('/logout') }}">
                                    <i data-toggle="tooltip" data-placement="bottom" title="{{ trans('pastebin.tooltip_logout') }}" class="fa fa-power-off" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </nav>

        <div class="container container-space">
            <div class="navbar-menu">
                <a href="{{ url('/') }}" class="btn btn-link"><i class="fa fa-home" aria-hidden="true"></i> {{ trans('pastebin.homepage') }}</a>
                <a href="#" class="btn btn-link"><i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('pastebin.last_activity') }}</a>
                <a href="#" class="btn btn-link"><i class="fa fa-heart" aria-hidden="true"></i> {{ trans('pastebin.favorites') }}</a>
            </div>

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

    <footer class="hidden-sm hidden-md hidden-xs">
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
    <script>
        new SimPas().bootSyntaxHighlighting(
            '{{ trans('pastebin.delete_confirmation_text') }}',
            '{{ trans('pastebin.button_confirmation_agree') }}',
            '{{ trans('pastebin.button_confirmation_no') }}'
        );
    </script>
</body>
</html>
