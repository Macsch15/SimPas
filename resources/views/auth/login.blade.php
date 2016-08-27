@extends('layout')

@section('title', trans('auth.login_page_title'))

@section('content')
    <div class="row row-border">
        <div class="col-md-12 col-md-offset-2">
            <h4>{{ trans('auth.login') }}</h5>

            {{ Form::open(['url' => route('auth.login.form')]) }}
                <div class="form-group row{{ $errors->has('email') ? ' has-warning' : '' }}">
                    {{ Form::label('email', trans('auth.email'), [
                        'class' => 'col-sm-2 col-form-label'
                    ]) }}
                    <div class="col-sm-10">
                        {{ Form::email('email', null, [
                            'class' => 'form-control' . ($errors->has('email') ? ' form-control-warning' : ''),
                            'placeholder' => trans('pastebin.email_example_placeholder'),
                            'id' => 'email'
                        ]) }}

                        @if ($errors->has('email'))
                            <div class="form-control-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row{{ $errors->has('password') ? ' has-warning' : '' }}">
                    {{ Form::label('password', trans('auth.password'), [
                        'class' => 'col-sm-2 col-form-label'
                    ]) }}
                    <div class="col-sm-10">
                        {{ Form::password('password', [
                            'class' => 'form-control' . ($errors->has('password') ? ' form-control-warning' : ''),
                            'placeholder' => '************',
                            'id' => 'password'
                        ]) }}

                        @if ($errors->has('password'))
                            <div class="form-control-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2"></label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            {{ Form::customCheckbox('remember_me', trans('auth.remember_me')) }}
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="offset-sm-2 col-sm-10">
                        {{ Form::button('<i class="fa fa-key" aria-hidden="true"></i> ' . trans('auth.login'), [
                            'class' => 'btn btn-outline-primary',
                            'type' => 'submit'
                        ])}}

                        <a class="btn btn-outline-secondary" href="{{ route('auth.register.form') }}">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> {{ trans('auth.register') }}
                        </a>
                        <a class="btn btn-outline-secondary" href="{{ route('auth.password_reset.form') }}">
                            <i class="fa fa-life-ring" aria-hidden="true"></i> {{ trans('auth.reset_password_link_title') }}
                        </a>
                    </div>
                </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection
