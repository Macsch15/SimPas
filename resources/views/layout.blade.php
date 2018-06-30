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
        <div class="navbar-container">
            <div class="container">
                <nav class="navbar navbar navbar-static-top">
                    <div class="navbar-toggleable-xs" id="navbar-header">
                        <div class="navbar-header">
                            <a class="navbar-brand" href="{{ url('/') }}">
                                <div class="brand-logo">
                                    SimPas
                                </div>
                            </a>

{{--                             @if (Breadcrumb::count())
                                <ol class="pull-left breadcrumb">
                                  <span class="breadcrumb-item active">{{ trans('pastebin.breadcrumb_pastebin') }}</span>
                                  @yield('breadcrumb')
                                </ol>
                            @endif   --}}            
                        </div>

                        @if (Auth::guest())
                            <div class="navbar-guest pull-right">
                                <a class="btn btn-link" href="{{ url('/login') }}">
                                    <i class="fa fa-key" aria-hidden="true"></i> {{ trans('pastebin.layout_button_login') }}
                                </a>
                                <a class="btn btn-link" href="{{ url('/register') }}">
                                    <i class="fa fa-user-plus" aria-hidden="true"></i> {{ trans('pastebin.layout_button_register') }}
                                </a>
                            </div>
                        @else
                            <div class="navbar-user pull-right">
                                <img class="user-avatar" width="30" src="//www.gravatar.com/avatar/{{ md5(Auth::user()->email) }}.jpg" alt="Avatar" />
                                {{ Auth::user()->name }}

                                <div class="pull-right logout-button">
                                    {{ Form::open(['route' => 'auth.logout']) }}
                                        {{ Form::button('<i class="fa fa-power-off" aria-hidden="true"></i>', [
                                                'type' => 'submit',
                                                'class' => 'btn btn-link',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'bottom',
                                                'title' => trans('pastebin.tooltip_logout')
                                            ])
                                        }}
                                    {{ Form::close() }}
                                </div>
                            </div>
                        @endif
                    </div>
                </nav>
            </div>
        </div>

        <div class="container container-space">
            <div class="navbar-menu">
                <a href="{{ route('pastebin.activity') }}" class="btn btn-link">
                    <i class="fa fa-list-alt" aria-hidden="true"></i> {{ trans('pastebin.last_activity') }}
                </a>
                <a href="#" class="btn btn-link">
                    <i class="fa fa-heart" aria-hidden="true"></i> {{ trans('pastebin.favorites') }}
                </a>
                <a href="#" class="btn btn-link">
                    <i class="fa fa-user-circle" aria-hidden="true"></i> My pastebin
                </a>
            </div>

            @if(Session::has('flash_message'))
                <div class="alert alert-success">
                    <i class="fa fa-check" aria-hidden="true"></i> {{ Session::get('flash_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                </div>
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
        var app = new SimPas();
    </script>
</body>
</html>
