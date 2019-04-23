@extends('layout')

@section('title', trans('auth.login_page_title'))

@section('content')
    <div class="row row-border">
        <div class="col-md-12 col-md-offset-2">
            <h4>{{ trans('auth.login') }}</h5>

            <form action="{{ route('auth.login.form') }}" method="POST">
                <div class="form-group row @error('email') has-warning @enderror">
                    <label for="email" class="col-sm-2 col-form-label">{{ trans('auth.email') }}</label>
                    <div class="col-sm-10">
                        <input type="email" name="email" class="form-control @error('email') form-control-warning @enderror" placeholder="{{ trans('pastebin.email_example_placeholder') }}" id="email" />

                        @error('email')
                            <div class="form-control-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row @error('password') has-warning @enderror">
                    <label for="password" class="col-sm-2 col-form-label">{{ trans('auth.password') }}</label>
                    <div class="col-sm-10">
                        <input type="password" name="password" class="form-control @error('password') form-control-warning @enderror" placeholder="************" id="password" />


                        @error('password')
                            <div class="form-control-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>


                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                </div>

                @csrf
                @method('POST')

                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-key" aria-hidden="true"></i> {{ trans('auth.login') }}
                        </button>

                        <a class="btn btn-outline-secondary" href="{{ route('auth.register.form') }}">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> {{ trans('auth.register') }}
                        </a>
                        <a class="btn btn-outline-secondary" href="{{ route('auth.password_reset.form') }}">
                            <i class="fa fa-life-ring" aria-hidden="true"></i> {{ trans('auth.reset_password_link_title') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
